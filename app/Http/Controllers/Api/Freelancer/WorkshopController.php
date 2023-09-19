<?php

namespace App\Http\Controllers\Api\Freelancer;

use App\FreelancerWorkshop;
use App\Http\Controllers\Admin\webPushController;
use App\Http\Controllers\Common;
use App\payment\Helpers\ModelBindingHelper;
use App\payment\Lib\HesabeCrypt;
use App\payment\Misc\Constants;
use App\payment\Misc\PaymentHandler;
use App\payment\Models\HesabeCheckoutResponseModel;
use App\PushDevices;
use App\Settings;
use App\UserNotification;
use App\WebPushMessage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WorkshopController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $user = Auth::user();
        $workshop = $user->workshops()->where('is_delete' , false)->with('area.city.country')->orderByDesc('id')->get()->toArray();
        $workshop = $this->deleteTranslations($workshop);
        return $this->apiResponse(200, ['data' => ['workshop' => $workshop], 'message' => []]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $this->validate($request, [
            'name'=>'required',
            'date'=>'required|date|after_or_equal:today|before:'. ( $user->expiration_date ?? "1990-01-01" ),
            'from_time'=>'required',
            'to_time'=>'nullable',
            'street'=>'required',
            'block'=>'required',
            'building_name'=>'required',
            'area_id'=>'required|numeric|exists:gwc_areas,id',
            'price'=>'required|numeric',
            'total_persons'=>'required|numeric',
        ]);
        if ($request->hasFile('file')) {
            $cover_image = Common::uploadImage($request, 'file', 'workshop', 0, 0, 0, 0);
            $request->merge([
                'images' => '/uploads/workshop/'.$cover_image
            ]);
        }
        $creat_price = $this->generateCreatPrice( $request->total_persons);
        $request->merge([
            'available' => $request->total_persons,
            'creat_price' => $creat_price,
            'order_track' => substr(time(), 5, 4) . rand(1000, 9999)
        ]);

        $workshops = $user->workshops()->create($request->except('file'));


        // Initialize the Payment request encryption/decryption library using the Secret Key and IV Key from the configuration
        $paymentHandler = new PaymentHandler(Constants::PAYMENT_API_URL, Constants::MERCHANT_CODE, Constants::MERCHANT_SECRET_KEY, Constants::MERCHANT_IV, Constants::ACCESS_CODE);
        // Getting the payment data into request object
        $requestData = $this->modelBindingHelper->getCheckoutRequestData(array('amount' => $creat_price, 'order_id' => $workshops->id, 'order_track' => $workshops->order_track, 'freelancer_id' => $user->id, 'type' => 'create_workshop'));

        // POST the requested object to the checkout API and receive back the response
        $response = $paymentHandler->checkoutRequest($requestData);

        //Get encrypted and decrypted checkout data response
        [$encryptedResponse, $hesabeCheckoutResponseModel] = $this->getCheckoutResponse($response);

        // check the response and validate it
        if ($hesabeCheckoutResponseModel->status == false && $hesabeCheckoutResponseModel->code != Constants::SUCCESS_CODE) {
            return $this->apiResponse(200, ['data' => [
                'workshop' => $workshops,
                'price' => $creat_price,
                'Url' => "",
                'token' => "" ,
                "can_pay" => false,
                'why_not' => [
                    'payment_status' => $hesabeCheckoutResponseModel->status ,
                    'payment_code' => $hesabeCheckoutResponseModel->code,
                ]
            ], 'message' => [trans('api.canNotMakeLink')]]);
        }

        $token = $hesabeCheckoutResponseModel->response['data'];

        return $this->apiResponse(200, ['data' => [
            'workshop' => $workshops,
            'price' => $creat_price,
            'Url' => Constants::PAYMENT_API_URL . '/payment?data=' . $token,
            'token' => $token,
            "can_pay" => true
        ], 'message' => []]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $user = Auth::user();
        $workshop = $user->workshops()->where('is_delete' , false)->with('area.city.country')->findOrFail($id);
        $workshopArray = $this->deleteTranslations([$workshop->toArray()])[0];

        if ( $workshop->is_approved == "pending_payment" ) {
            // Initialize the Payment request encryption/decryption library using the Secret Key and IV Key from the configuration
            $paymentHandler = new PaymentHandler(Constants::PAYMENT_API_URL, Constants::MERCHANT_CODE, Constants::MERCHANT_SECRET_KEY, Constants::MERCHANT_IV, Constants::ACCESS_CODE);
            // Getting the payment data into request object
            $requestData = $this->modelBindingHelper->getCheckoutRequestData(array('amount' => $workshop->creat_price, 'order_id' => $workshop->id, 'order_track' => $workshop->order_track, 'freelancer_id' => $user->id, 'type' => 'create_workshop'));

            // POST the requested object to the checkout API and receive back the response
            $response = $paymentHandler->checkoutRequest($requestData);

            //Get encrypted and decrypted checkout data response
            [$encryptedResponse, $hesabeCheckoutResponseModel] = $this->getCheckoutResponse($response);

            // check the response and validate it
            if ($hesabeCheckoutResponseModel->status == false && $hesabeCheckoutResponseModel->code != Constants::SUCCESS_CODE) {
                return $this->apiResponse(200, ['data' => [
                    'workshop' => $workshopArray,
                    'price' => $workshop->creat_price,
                    'Url' => "",
                    'token' => "" ,
                    "can_pay" => false,
                    'why_not' => [
                        'payment_status' => $hesabeCheckoutResponseModel->status ,
                        'payment_code' => $hesabeCheckoutResponseModel->code,
                    ]
                ], 'message' => [trans('api.canNotMakeLink')]]);
            }

            $token = $hesabeCheckoutResponseModel->response['data'];

            return $this->apiResponse(200, ['data' => [
                'workshop' => $workshopArray,
                'price' => $workshop->creat_price,
                'Url' => Constants::PAYMENT_API_URL . '/payment?data=' . $token,
                'token' => $token,
                "can_pay" => true
            ], 'message' => []]);
        }
        return $this->apiResponse(200, ['data' => [
            'workshop' => $workshopArray,
            'price' => $workshop->creat_price,
            'Url' => "",
            'token' => "" ,
            "can_pay" => false,
            'why_not' => [
                'payment_status' => 'User paid' ,
                'payment_code' => 0,
            ]
        ], 'message' => []]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'=>'required',
            'date'=>'required|date',
            'from_time'=>'required',
            'to_time'=>'nullable',
            'street'=>'required',
            'block'=>'required',
            'building_name'=>'required',
            'area_id'=>'required|numeric|exists:gwc_areas,id',
            'price'=>'required|numeric',
            'total_persons'=>'required|numeric',
        ]);
        $user = Auth::user();
        $workshop = $user->workshops()->where('is_delete' , false)->findOrFail($id);
        if ($request->hasFile('file')) {
            $cover_image = Common::uploadImage($request, 'file', 'workshop', 0, 0, 0, 0);
            $request->merge([
                'images' => '/uploads/workshop/'.$cover_image
            ]);
        }
        $request->merge([
            'available' => $request->total_persons - $workshop->reserved,
        ]);
        $workshops = $workshop->update($request->except('file'));
        return $this->apiResponse(200, ['data' => ['workshop' => $workshops ], 'message' => []]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $workshop = $user->workshops()->findOrFail($id);
        if ( $workshop->reserved == 0 ) {
            $workshop->delete();
            return $this->apiResponse(200, ['data' => [], 'message' => [trans('api.freelancer.cancellation.workshop')]]);
        } else {
            DB::beginTransaction();
            try {
                foreach ($workshop->orders as $order) {
                    $order->payment_status = 'freelancer_cancel';
                    $order->save();
                    UserNotification::add($order->user_id, $order->freelancer_id, ['cancellationWorkshopByFreelancer', $user->name, $workshop->date], 'cancellationWorkshopByFreelancer', ['workshop_id' => $workshop->id , 'order_id' => $order->id]);
                }
                $workshop->reserved = 0 ;
                $workshop->is_delete = true ;
                $workshop->available = $workshop->total_persons ;
                $workshop->is_active = false;
                $workshop->save();
            } catch ( \Exception $exception){
                DB::rollBack();
                return $this->apiResponse(500, ['data' => [], 'message' => [$exception->getMessage()]]);
            }
            DB::commit();
            return $this->apiResponse(200, ['data' => [], 'message' => [trans('api.freelancer.cancellation.workshop')]]);
        }
    }




    private function deleteTranslations($datas)
    {
        if ( is_array($datas)){
            foreach ($datas as $index => $data){
                if ( isset($data['children_recursive']) and is_array($data['children_recursive']) and count($data['children_recursive']) > 0)
                    $datas[$index]['children_recursive'] = $this->deleteTranslations($data['children_recursive']);
                unset($datas[$index]['translations']);
                $datas[$index]['description'] = strip_tags($datas[$index]['description']);
            }
        }
        return $datas;
    }

    private function generateCreatPrice($total_persons)
    {
        $cost = FreelancerWorkshop::$cost;
        $default = $cost['more'] ?? 0;
        unset($cost['more']);
        ksort($cost);
        foreach ( $cost as $max_person => $price )
            if ( $total_persons <= $max_person )
                return $price;
        return  $default;
    }

    public function generatePriceList()
    {
        $cost = FreelancerWorkshop::$cost;
        $default = $cost['more'] ?? 0;
        unset($cost['more']);
        ksort($cost);
        $result = [];
        $result2 = [];
        $lastPerson = 0 ;
        foreach ( $cost as $max_person => $price ) {
            $result[] = [
                'from_person' => $lastPerson,
                'to_person' => $max_person,
                'price' => $price,
            ];
            $result2[$lastPerson.'-'.$max_person] = $price;
            $lastPerson = $max_person + 1;
        }
        $result[] = [
            'from_person' => $lastPerson,
            'to_person' => PHP_INT_MAX,
            'price' => $default,
        ];
        $result2[$lastPerson.'-∞'] = $default;
        return $this->apiResponse(200, ['data' => ['price_list' => $result2 , 'price_table' => $result ], 'message' => []]);
    }



    /**
     * Process the response after the form data has been requested.
     *
     * @return array De-serialize the decrypted response
     *
     */
    public function getCheckoutResponse($response)
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
