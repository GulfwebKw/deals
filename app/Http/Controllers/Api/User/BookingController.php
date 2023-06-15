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
use App\UserNotification;
use App\UserOrder;
use App\UserWaiting;
use App\WorkshopOrder;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller

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

    public function rescheduleService(Request $request , $id , $slotId)
    {
        $request->merge(['slot_id' => $slotId]);
        $validator = Validator::make($request->all(), [
            'slot_id' => 'required|exists:time_calenders,id',
        ]);
        if ($validator->fails()) {
            return $this->apiResponse(422, ['data' => [], 'message' => $validator->errors()->all()]);
        }

        $user= Freelancer::find(TimeCalender::find($request->slot_id)->freelancer_id);
        $service = ServiceUserOrders::where('freelancer_id' , $user->id )
            ->whereIn('status' , ['booked' ,'freelancer_reschedule' ,'user_reschedule','admin_reschedule'])
            ->findOrfail($id);

        if ( Carbon::now()->addHours(12)->gte( Carbon::parse($service->date .' '.$service->time)->format('Y-m-d H:i:s'))){
            return $this->apiResponse(400, ['data' => [], 'message' => [trans('api.rescheduleService12H')]]);
        }
        DB::beginTransaction();
        try {
            $lastTime = $service->timeSlot;
            $time = $user->calendar()->where('status', 'free')->findOrFail($request->slot_id);
            if(isset($lastTime)){
                $lastTime->status = "free";
                $lastTime->bookedable_id = null;
                $lastTime->bookedable_type = null ;
            }
            $time->status = "booked";
            $time->bookedable_id = $service->id;
            $time->bookedable_type = ServiceUserOrders::class ;
            $time->save();
            if(isset($lastTime)) $lastTime->save();
            FreelancerNotification::add($service->order->user_id,$service->freelancer_id,['reschedule' , $user->Fullname , $service->date .' '.$service->time , [] , $time->date .' '. $time->start_time ],'reschedule',['service_id' => $service->id]);
            $service->status = "user_reschedule";
            $service->date = $time->date;
            $service->time = $time->start_time;
            $service->save();
            DB::commit();
            return $this->apiResponse(200, ['data' => [], 'message' => [trans('api.user.reschedule.service')]]);
        } catch(ModelNotFoundException $exception)  {
            DB::rollBack();
            return $this->apiResponse(404, ['data' => [ 'model' =>$exception->getModel() , 'ids' => $exception->getIds() ], 'message' => [$exception->getMessage()]]);
        }catch ( \Exception $exception){
            DB::rollBack();
            return $this->apiResponse(500, ['data' => [$exception->getMessage()], 'message' => [trans('api.canNotRescheduleService')]]);
        }
    }


    public function bookUserService(Request $request)
    {
//        return $this->apiResponse(500, ['data' => [$request->all()], 'message' => ['can not order now!']]);
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
                if (!$freelancer->is_active or $freelancer->offline) {
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
                        return $this->apiResponse(400, ['data' => null, 'message' => [trans('api.selectLocationOtherArea')]]);
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

    public function workshopBook(Request $request)
    {
        $this->validate($request, [
            'workshop_id' => 'required|exists:freelancer_workshops,id',
            'people' => 'required|numeric',
        ]);
        DB::beginTransaction();
        try {
            $source = FreelancerWorkshop::findOrFail($request->workshop_id);
            $freelancer = $source->freelancer;
            if (!$freelancer->is_active or
                $freelancer->offline or
                $source->date < Carbon::yesterday() or
                \Illuminate\Support\Carbon::now()->gte($freelancer->expiration_date)) {
                return $this->apiResponse(404, ['data' => [], 'message' => [trans('api.deactivateWorkshop')]]);
            }
            if ($source->available < intval($request->people))
                return $this->apiResponse(200, ['data' => ['available' => $source->available], 'message' => [trans('api.workshopFull')]]);

            switch ($freelancer->service_commission_type) {
                case 'price':
                    if ($source->price - $freelancer->service_commission_price > 0) {
                        $earn = $source->price - $freelancer->service_commission_price;
                        $commission = $freelancer->service_commission_price;
                    } else {
                        $earn = 0;
                        $commission = $source->price;
                    }
                    break;
                case 'percent':
                    $earn = round($source->price * (100 - $freelancer->service_commission_percent) / 100);
                    $commission = $source->price - $earn;
                    break;
                case 'plus':
                    $earnTemp = round($source->price * (100 - $freelancer->service_commission_percent) / 100) - $freelancer->service_commission_price;
                    $earn = ($earnTemp > 0) ? $earnTemp : 0;
                    $commission = ($earnTemp > 0) ? $source->price - $earnTemp : $source->price;
                    break;
                case 'min':
                    $earnTempPercent = round($source->price * (100 - $freelancer->service_commission_percent) / 100);
                    $earnTempPrice = ($source->price - $freelancer->service_commission_price > 0) ? $source->price - $freelancer->service_commission_price : 0;
                    $earn = max($earnTempPercent, $earnTempPrice);
                    $commission = $source->price - $earn;
                    break;
                case 'max':
                    $earnTempPercent = round($source->price * (100 - $freelancer->service_commission_percent) / 100);
                    $earnTempPrice = ($source->price - $freelancer->service_commission_price > 0) ? $source->price - $freelancer->service_commission_price : 0;
                    $earn = min($earnTempPercent, $earnTempPrice);
                    $commission = $source->price - $earn;
                    break;
                default :
                    $earn = $source->price;
                    $commission = 0;
                    break;
            }

            $amount = $source->price * $request->people;
            $earn = $earn * $request->people;
            $commission = $commission * $request->people;
            $workshop = WorkshopOrder::create([
                'user_id' => Auth::id(),
                'workshop_id' => $source->id,
                'freelancer_id' => $source->freelancer_id,
                'order_track' => substr(time(), 5, 4) . rand(1000, 9999),
                'people_count' => $request->people,
                'amount' => $amount,
                'earn' => $earn,
                'commission' => $commission,
            ]);
            $source->reserved = intval($source->reserved + $request->people);
            $source->available = intval($source->total_persons - $source->reserved);
            $source->save();


            // Initialize the Payment request encryption/decryption library using the Secret Key and IV Key from the configuration
            $paymentHandler = new PaymentHandler($this->paymentApiUrl, $this->merchantCode, $this->secretKey, $this->ivKey, $this->accessCode);
            // Getting the payment data into request object
            $requestData = $this->modelBindingHelper->getCheckoutRequestData(array('amount' => $workshop->amount, 'order_id' => $workshop->id, 'order_track' => $workshop->order_track, 'freelancer_id' => null, 'type' => 'workshop'));

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
                'workshop' => $source,
                'Url' => $this->paymentApiUrl . '/payment?data=' . $token,
                'token' => $token
            ], 'message' => [trans('api.user.booked.workshop')]]);

        } catch(ModelNotFoundException $exception)  {
            DB::rollBack();
            return $this->apiResponse(404, ['data' => [ 'model' =>$exception->getModel() , 'ids' => $exception->getIds() ], 'message' => [$exception->getMessage()]]);
        } catch ( \Exception $exception){
            DB::rollBack();
            return $this->apiResponse(500, ['data' => [$exception->getMessage()], 'message' => [trans('api.notOrderNow')]]);
        }
    }

    public function getServiceOrder($id){
        $user=Auth::user();
        $order = UserOrder::where('user_id' , $user->id )
            ->with(['services' , 'services.service' , 'services.timeSlot'])
            ->findOrfail($id);
        if(  $order->payment_status == "waiting"){
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
                return $this->apiResponse(200, ['data' => ['order' => $order], 'message' => []]);
            }
            $token = $hesabeCheckoutResponseModel->response['data'];
            return $this->apiResponse(200, ['data' => [
                'order' => $order,
                'Url' => $this->paymentApiUrl . '/payment?data=' . $token,
                'token' => $token
            ], 'message' => []]);
        }
        return $this->apiResponse(200, ['data' => ['order' => $order], 'message' => []]);
    }

    public function cancel($id){
        $user=Auth::user();
        $service = ServiceUserOrders::whereIn('status' , ['booked' ,'freelancer_reschedule' ,'user_reschedule','admin_reschedule'])
            ->with(['timeSlot', 'order' , 'freelancer'])
            ->findOrfail($id);
        if ( Carbon::now()->addHours(12)->gte( Carbon::parse($service->date .' '.$service->time)->format('Y-m-d H:i:s'))){
            return $this->apiResponse(400, ['data' => [], 'message' => [trans('api.canNotCancelService')]]);
        }
        $order = $service->order;
        if ( $order->user_id != $user->id )
            return $this->apiResponse(403, ['data' => [], 'message' => [trans('api.notAccess')]]);

        DB::beginTransaction();
        try {
            $timeSlot = $service->timeSlot;
            if ( $timeSlot != null ) {
                $timeSlot->status = 'free';
                $timeSlot->bookedable_id = null;
                $timeSlot->bookedable_type = null;
                $timeSlot->save();
            }
            $service->status = "user_cancel";
            $service->save();
            $order->refund = $order->refund + $service->price ;
            $order->save();
            FreelancerNotification::add($service->user_id,$service->freelancer_id,['cancellation' , $user->Fullname , $service->date .' '.$service->time ],'cancellation',['service_id' => $service->id]);
            UserNotification::add($service->user_id,$service->freelancer_id,['cancellationMySelf' , $service->freelancer->name , $service->date .' '.$service->time , [] , null , $user->Fullname ],'cancellationMySelf',['booking_id' => $service->id]);
        } catch (\Exception $e ){
            DB::rollBack();
            return $this->apiResponse(500, ['data' => [], 'message' => [$e->getMessage()]]);
        }
        DB::commit();
        return $this->apiResponse(200, ['data' => [], 'message' => [trans('api.user.cancellation.service')]]);
    }

    public function getWorkshopOrder($id){
        $user=Auth::user();
        $workshop = WorkshopOrder::where('user_id' , $user->id )
            ->with(['workshop'])
            ->findOrfail($id);
        if(  $workshop->payment_status == "waiting"){
            // Initialize the Payment request encryption/decryption library using the Secret Key and IV Key from the configuration
            $paymentHandler = new PaymentHandler($this->paymentApiUrl, $this->merchantCode, $this->secretKey, $this->ivKey, $this->accessCode);
            // Getting the payment data into request object
            $requestData = $this->modelBindingHelper->getCheckoutRequestData(array('amount' => $workshop->amount, 'order_id' => $workshop->id, 'order_track' => $workshop->order_track, 'freelancer_id' => null, 'type' => 'workshop'));

            // POST the requested object to the checkout API and receive back the response
            $response = $paymentHandler->checkoutRequest($requestData);

            //Get encrypted and decrypted checkout data response
            [$encryptedResponse, $hesabeCheckoutResponseModel] = $this->getCheckoutResponse($response);

            // check the response and validate it
            if ($hesabeCheckoutResponseModel->status == false && $hesabeCheckoutResponseModel->code != Constants::SUCCESS_CODE) {
                return $this->apiResponse(200, ['data' => ['workshop' => $workshop], 'message' => []]);
            }
            $token = $hesabeCheckoutResponseModel->response['data'];
            return $this->apiResponse(200, ['data' => [
                'workshop' => $workshop,
                'Url' => $this->paymentApiUrl . '/payment?data=' . $token,
                'token' => $token
            ], 'message' => []]);
        }
        return $this->apiResponse(200, ['data' => ['workshop' => $workshop], 'message' => []]);
    }

    public function cancelWorkshopOrder($id){
        $user=Auth::user();
        $order = WorkshopOrder::where('user_id' , $user->id )
            ->with(['workshop'])
            ->findOrfail($id);
        $workshop = $order->workshop;
        if ( Carbon::now()->addHours(12)->gte( Carbon::parse($workshop->date .' '.$workshop->from_time)->format('Y-m-d H:i:s'))){
            return $this->apiResponse(400, ['data' => [], 'message' => [trans('api.canNotCancelWorkshop')]]);
        }
        $workshop->reserved = $workshop->reserved - $order->people_count;
        $workshop->available = intval($workshop->total_persons) - $order->reserved;
        $workshop->save();
        if(  $order->payment_status == "waiting"){
            $order->delete();
        } else {
            $order->payment_status = "cancel";
            $order->save();
            FreelancerNotification::add($order->user_id,$order->workshop->freelancer_id,['workshopCancel' , $order->user->Fullname ],'workshopCancel',['workshop_id' => $order->workshop->id]);
        }
        return $this->apiResponse(200, ['data' => ['workshop' => $order], 'message' => [trans('api.CancelWorkshop')]]);
    }


    public function waitingList(Request $request){
        $user=Auth::user();
        //$settings = Settings::where("keyname", "setting")->first();
        //$pageNumber = $request->hasHeader('per-page') ? (int) $request->header('per-page') : $settings->item_per_page_back ;
        $waitingList = $user->waiting()
            ->where('date' , '>' , Carbon::now())
            ->whereHas('freelancer', function($query){
                $query->where('is_active',1)
                    ->where('offline',0)
                    ->whereDate('expiration_date' , '>=', \Illuminate\Support\Carbon::now());
            })
            ->whereHas('service', function($query){
                $query->where('is_active',1)
                    ->whereNull('deleted_at');
            })->with('freelancer' , 'service')->orderBy('date')->orderBy('freelancer_id')->orderBy('freelancer_id')
            //->paginate($pageNumber);
        //return $this->apiResponse(200, ['data' => ['waiting' => $waitingList], 'message' => [']]);

            ->get();
        $data = [];
        foreach ( $waitingList  as $object ) {
//            if ( ! isset($data[$object->date->format('Y-m-d')]))
//                $data[$object->date->format('Y-m-d')] = [
//                    'date' => $object->date->format('Y-m-d'),
//                    'freelancers' => []
//                ];
//
//            if ( ! isset($data[$object->date->format('Y-m-d')]['freelancers'][$object->freelancer_id]) )
//                $data[$object->date->format('Y-m-d')]['freelancers'][$object->freelancer_id] = [
//                    'freelancer'=>$object->freelancer,
//                    'booked_services' => []
//                ];
//
//            $data[$object->date->format('Y-m-d')]['freelancers'][$object->freelancer_id]['booked_services'][] = $object->service ;

            if ( ! isset($data[$object->date->format('Y-m-d').'|'.$object->freelancer_id]) )
                $data[$object->date->format('Y-m-d').'|'.$object->freelancer_id] = [
                    'date' => $object->date->format('Y-m-d'),
                    'freelancer'=>$object->freelancer,
                    'booked_services' => []
                ];

            $data[$object->date->format('Y-m-d').'|'.$object->freelancer_id]['booked_services'][] = $object->service ;

        }
//        foreach ( $data  as $index => $object ) {
//            $data[$index]['freelancers'] = array_values($data[$index]['freelancers']);
//        }
        $data = array_values($data);
        return $this->apiResponse(200, ['data' => ['waiting' => $data], 'message' => []]);

    }
}