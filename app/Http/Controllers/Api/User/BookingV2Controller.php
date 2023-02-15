<?php

namespace App\Http\Controllers\Api\User;

use App\Freelancer;
use App\FreelancerNotification;
use App\FreelancerServices;
use App\FreelancerWorkshop;
use App\Http\Controllers\Controller;
use App\Order;
use App\payment\Helpers\ModelBindingHelper;
use App\payment\Lib\HesabeCrypt;
use App\payment\Misc\Constants;
use App\payment\Misc\PaymentHandler;
use App\payment\Models\HesabeCheckoutResponseModel;
use App\ServiceUserOrders;
use App\Settings;
use App\TimeCalender;
use App\UserOrder;
use App\UserWaiting;
use App\WorkshopOrder;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BookingV2Controller extends Controller

{
    public $paymentApiUrl;
    public $secretKey;
    public $merchantCode;
    public $ivKey;
    public $accessCode;
    public $hesabeCheckoutResponseModel;
    public $modelBindingHelper;
    public $hesabeCrypt;

    public function __construct()
    {
        $this->paymentApiUrl = Constants::PAYMENT_API_URL;
        // Get all three values from Merchant Panel, Profile section
        $this->secretKey = Constants::MERCHANT_SECRET_KEY;  // Use Secret key
        $this->merchantCode = Constants::MERCHANT_CODE;
        $this->ivKey = Constants::MERCHANT_IV;              // Use Iv Key
        $this->accessCode = Constants::ACCESS_CODE;         // Use Access Code
        $this->hesabeCheckoutResponseModel = new HesabeCheckoutResponseModel();
        $this->modelBindingHelper = new ModelBindingHelper();
        $this->hesabeCrypt = new HesabeCrypt();   // instance of Hesabe Crypt library
    }

    public function bookOneService(Request $request)
    {
//        return $this->apiResponse(500, ['data' => [$request->all()], 'message' => ['can not order now!']]);
        $this->validate($request , [
            'service_id' => 'required|exists:freelancer_services,id',
            'date' => 'nullable|date',
            'slot_id' => 'nullable|exists:time_calenders,id',
            'people' => 'required',
            'freelancer_location_id' => 'nullable|exists:freelancer_addresses,id',
            'user_location_id' => 'nullable|exists:addresses,id',
        ]);
        $user=Auth::user();
        try {
            $item = $request->all();

            $item['freelancer_location_id'] = $item['freelancer_location_id'] ?? null;
            $item['user_location_id'] = $item['user_location_id'] ?? null;
            $item['date'] = $item['date'] ?? null;
            $item['slot_id'] = $item['slot_id'] ?? null;
            $item['previous_response'] = str_replace('\"' , '"' , $item['previous_response']) ?? null;
            $lastResponse = unserialize($item['previous_response']) ?? [];


            $service = FreelancerServices::where('is_active', 1)->findOrFail($item['service_id']);

            $freelancer = $service->freelancer;
            if (!$freelancer->is_active or $freelancer->offline or
                \Illuminate\Support\Carbon::now()->gte($freelancer->expiration_date))
                return $this->apiResponse(404, ['data' => serialize($lastResponse), 'message' => [trans('api.deactivateService')]]);

            if (
                    ($item['freelancer_location_id'] == null and $item['user_location_id'] == null) or
                    ($item['freelancer_location_id'] == null and $freelancer->location_type == "my") or
                    ($item['user_location_id'] == null and $freelancer->location_type == "any")
                )
                return $this->apiResponse(400, ['data' => serialize($lastResponse), 'message' => [trans('api.selectLocation')]]);

            if ($item['user_location_id'] != null and ($freelancer->location_type == "both" or $freelancer->location_type == "any")) {
                $userAddress = $user->address()->findOrFail($item['user_location_id']);
                if (!$freelancer->areas()->where('freelancer_areas.area_id', $userAddress->area_id)->exists())
                    return $this->apiResponse(400, ['data' => serialize($lastResponse), 'message' => [trans('api.selectLocationOtherArea')]]);
            }
            if ($item['date'] == null and $item['slot_id'] == null)
                return $this->apiResponse(400, ['data' => serialize($lastResponse), 'message' => [trans('api.selectSlot')]]);

            if ($item['slot_id'] != null)
                $freelancer->calendar()->where('status', 'free')->findOrFail($item['slot_id']);
            else {
                if ( Carbon::now()->addHours(12)->gte( Carbon::parse($item['date'] .' 0:0:0')->format('Y-m-d H:i:s')))
                    return $this->apiResponse(400, ['data' => serialize($lastResponse), 'message' => [trans('api.addWaiting12H')]]);

                $timeHas = $freelancer->calendar()
                    ->where('date', $item['date'])->count();
                if ( $timeHas == 0 )
                    return $this->apiResponse(400, ['data' => serialize($lastResponse), 'message' => [trans('api.getOrderDate' , ['date' =>  $item['date'] ])]]);

                $timeHas = $freelancer->calendar()
                    ->where('date', $item['date'])->where('status','free')->count();
                if ( $timeHas >  0 )
                    return $this->apiResponse(400, ['data' => serialize($lastResponse), 'message' => [trans('api.hasFreeTime' , ['date' =>  $item['date'] ])]]);

            }
            unset($item['previous_response']);
            $lastResponse[] = $item;

            return $this->apiResponse(200, ['data' => serialize($lastResponse), 'message' => []]);

        } catch(ModelNotFoundException $exception)  {
            return $this->apiResponse(404, ['data' => [ 'model' =>$exception->getModel() , 'ids' => $exception->getIds() ], 'message' => [$exception->getMessage()]]);
        } catch ( \Exception $exception){
            return $this->apiResponse(500, ['data' => [ 'error' => $exception->getMessage()], 'message' => [trans('api.notOrderNow')]]);
        }
    }


    public function bookUserService(Request $request)
    {
//        return $this->apiResponse(500, ['data' => [$request->all()], 'message' => ['can not order now!']]);
        $lastResponse = unserialize(str_replace('\"' , '"' , $request->services)) ?? [];
        $request->merge(['services' => $lastResponse]);
        $this->validate($request , [
            'services.*.service_id' => 'required|exists:freelancer_services,id',
            'services.*.date' => 'nullable|date',
            'services.*.slot_id' => 'nullable|exists:time_calenders,id',
            'services.*.people' => 'required',
            'services.*.freelancer_location_id' => 'nullable|exists:freelancer_addresses,id',
            'services.*.user_location_id' => 'nullable|exists:addresses,id',
        ]);
        $user=Auth::user();
        DB::beginTransaction();
        try {
            $services = $request->services;
            $order = new UserOrder();
            $order->user_id = Auth::id();
            $order->order_track = substr(time(), 5, 4) . rand(1000, 9999);
            $order->amount = 0;
            $order->payment_status = "waiting";
            $order->save();
            $amount = 0;
            $hasWaitingList = false;
            $hasPay = false ;
            foreach ($services as $item) {
                $item['freelancer_location_id'] = $item['freelancer_location_id'] ?? null;
                $item['user_location_id'] = $item['user_location_id'] ?? null;
                $item['date'] = $item['date'] ?? null;
                $item['slot_id'] = $item['slot_id'] ?? null;
                $service = FreelancerServices::where('is_active', 1)->findOrFail($item['service_id']);

                $freelancer = $service->freelancer;
                if (!$freelancer->is_active or $freelancer->offline or
                    \Illuminate\Support\Carbon::now()->gte($freelancer->expiration_date)) {
                    DB::rollBack();
                    return $this->apiResponse(404, ['data' => [$item['service_id']], 'message' => [trans('api.deactivateService')]]);
                }
                if (
                    ($item['freelancer_location_id'] == null and $item['user_location_id'] == null) or
                    ($item['freelancer_location_id'] == null and $freelancer->location_type == "my") or
                    ($item['user_location_id'] == null and $freelancer->location_type == "any")) {
                    DB::rollBack();
                    return $this->apiResponse(400, ['data' => ["freelancer_location" => $freelancer->location_type, "service_id" => $item['service_id']], 'message' => [trans('api.selectLocation')]]);
                }
                if ($item['user_location_id'] != null and ($freelancer->location_type == "both" or $freelancer->location_type == "any")) {
                    $userAddress = $user->address()->findOrFail($item['user_location_id']);
                    if (!$freelancer->areas()->where('freelancer_areas.area_id', $userAddress->area_id)->exists()) {
                        DB::rollBack();
                        return $this->apiResponse(400, ['data' => serialize($lastResponse), 'message' => [trans('api.selectLocationOtherArea')]]);
                    }
                }
                if ($item['date'] == null and $item['slot_id'] == null) {
                    DB::rollBack();
                    return $this->apiResponse(400, ['data' => [], 'message' => [trans('api.selectSlot')]]);
                }
                if ($item['slot_id'] != null) {
                    $time = $freelancer->calendar()->where('status', 'free')->findOrFail($item['slot_id']);
                    $time->status = "preorder";
                    $time->save();
                } else {
                    if ( $item['date'] != null ){
                        if ( Carbon::now()->addHours(12)->gte( Carbon::parse($item['date'] .' 0:0:0')->format('Y-m-d H:i:s'))){
                            DB::rollBack();
                            return $this->apiResponse(400, ['data' => [], 'message' => [trans('api.addWaiting12H')]]);
                        }
                        $timeHas = $freelancer->calendar()
                            ->where('date', $item['date'])->count();
                        if ( $timeHas == 0 ){
                            DB::rollBack();
                            return $this->apiResponse(400, ['data' => [], 'message' => [trans('api.getOrderDate' , ['date' =>  $item['date'] ])]]);
                        }
                        $timeHas = $freelancer->calendar()
                            ->where('date', $item['date'])->where('status','free')->count();
                        if ( $timeHas >  0 ){
                            DB::rollBack();
                            return $this->apiResponse(400, ['data' => [], 'message' => [trans('api.hasFreeTime' , ['date' =>  $item['date'] ])]]);
                        }
                        UserWaiting::create([
                            'user_id' =>  Auth::id(),
                            'freelancer_id' =>  $freelancer->id,
                            'service_id' =>  $item['service_id'],
                            'date' =>  $item['date'],
                        ]);
                        $hasWaitingList = true ;
                        continue;
                    }
                }
                switch ($freelancer->service_commission_type) {
                    case 'price':
                        if ($service->price - $freelancer->service_commission_price > 0) {
                            $earn = $service->price - $freelancer->service_commission_price;
                            $commission = $freelancer->service_commission_price;
                        } else {
                            $earn = 0;
                            $commission = $service->price;
                        }
                        break;
                    case 'percent':
                        $earn = round($service->price * (100 - $freelancer->service_commission_percent) / 100);
                        $commission = $service->price - $earn;
                        break;
                    case 'plus':
                        $earnTemp = round($service->price * (100 - $freelancer->service_commission_percent) / 100) - $freelancer->service_commission_price;
                        $earn = ($earnTemp > 0) ? $earnTemp : 0;
                        $commission = ($earnTemp > 0) ? $service->price - $earnTemp : $service->price;
                        break;
                    case 'min':
                        $earnTempPercent = round($service->price * (100 - $freelancer->service_commission_percent) / 100);
                        $earnTempPrice = ($service->price - $freelancer->service_commission_price > 0) ? $service->price - $freelancer->service_commission_price : 0;
                        $earn = max($earnTempPercent, $earnTempPrice);
                        $commission = $service->price - $earn;
                        break;
                    case 'max':
                        $earnTempPercent = round($service->price * (100 - $freelancer->service_commission_percent) / 100);
                        $earnTempPrice = ($service->price - $freelancer->service_commission_price > 0) ? $service->price - $freelancer->service_commission_price : 0;
                        $earn = min($earnTempPercent, $earnTempPrice);
                        $commission = $service->price - $earn;
                        break;
                    default :
                        $earn = $service->price;
                        $commission = 0;
                        break;
                }
                $serviceOrdered = ServiceUserOrders::create([
                    'order_id' => $order->id,
                    'service_id' => $item['service_id'],
                    'freelancer_id' => $freelancer->id,
                    'date' => $time->date,
                    'time' => $time->start_time,
//                    'slot_id' => (isset($time) ? $time->id : null ),
                    'price' => $service->price,
                    'earn' => $earn,
                    'commission' => $commission,
                    'freelancer_location_id' => $item['freelancer_location_id'],
                    'people' => $item['people'],
                    'user_location_id' => $item['user_location_id'],
                ]);
                if ($item['slot_id'] != null) {
                    $time->bookedable_id = $serviceOrdered->id;
                    $time->bookedable_type = ServiceUserOrders::class ;
                    $time->save();
                    unset($time);
                }
                $amount = $amount + $service->price;
                $hasPay = true ;
            }
            $order->amount = $amount;
            $order->save();
            if ( $hasPay ) {
                // Initialize the Payment request encryption/decryption library using the Secret Key and IV Key from the configuration
                $paymentHandler = new PaymentHandler($this->paymentApiUrl, $this->merchantCode, $this->secretKey, $this->ivKey, $this->accessCode);
                // Getting the payment data into request object
                $requestData = $this->modelBindingHelper->getCheckoutRequestData(array('amount' => $order->amount, 'order_id' => $order->id, 'order_track' => $order->order_track, 'freelancer_id' => null, 'type' => 'service'));

                // POST the requested object to the checkout API and receive back the response
                $response = $paymentHandler->checkoutRequest($requestData);

                //Get encrypted and decrypted checkout data response
                [$encryptedResponse, $hesabeCheckoutResponseModel] = $this->getCheckoutResponse($response);

                // check the response and validate it
                if ($hesabeCheckoutResponseModel->status == false && $hesabeCheckoutResponseModel->code != Constants::SUCCESS_CODE) {
                    DB::rollBack();
                    return $this->apiResponse(500, ['data' => [], 'message' => [trans('api.notOrderNow')]]);
                }

                $token = $hesabeCheckoutResponseModel->response['data'];
                DB::commit();
                return $this->apiResponse(200, ['data' => [
                    'order' => $order,
                    'hasWaitingList' => $hasWaitingList,
                    'redirectToBankGateway' => true,
                    'Url' => $this->paymentApiUrl . '/payment?data=' . $token,
                    'token' => $token
                ], 'message' => [trans('api.user.booked.service')]]);
            } else {
                $order->delete();
                DB::commit();
                return $this->apiResponse(200, ['data' => [
                    'order' => $order,
                    'hasWaitingList' => $hasWaitingList,
                    'redirectToBankGateway' => false,
                    'Url' => "",
                    'token' => ""
                ], 'message' => [trans('api.user.booked.service')]]);

            }

            // Redirect the user to the payment page using the token from the checkout API response
        } catch(ModelNotFoundException $exception)  {
            DB::rollBack();
            return $this->apiResponse(404, ['data' => [ 'model' =>$exception->getModel() , 'ids' => $exception->getIds() ], 'message' => [$exception->getMessage()]]);
        } catch ( \Exception $exception){
            DB::rollBack();
            return $this->apiResponse(500, ['data' => [ 'error' => $exception->getMessage()], 'message' => [trans('api.notOrderNow')]]);
        }
    }

    private function getCheckoutResponse($response)
    {

        // Decrypt the response from the checkout API
        $decryptResponse = $this->hesabeCrypt::decrypt($response, $this->secretKey, $this->ivKey);

        if (!$decryptResponse) {
            $decryptResponse = $response;
        }

        // De-serialize the JSON string into an object
        $decryptResponseData = json_decode($decryptResponse, true);

        //Binding the decrypted response data to the entity model
        $decryptedResponse = $this->modelBindingHelper->getCheckoutResponseData($decryptResponseData);

        //return encrypted and decrypted data
        return [$response, $decryptedResponse];
    }


}