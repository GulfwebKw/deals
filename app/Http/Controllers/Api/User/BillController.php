<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Common;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\payment\Helpers\ModelBindingHelper;
use App\payment\Lib\HesabeCrypt;
use App\payment\Misc\Constants;
use App\payment\Misc\PaymentHandler;
use App\payment\Models\HesabeCheckoutResponseModel;
use Carbon\Carbon;

class BillController extends Controller
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $user = Auth::user();
        $bill = $user->bills()->where('id' , $id)->orwhere('uuid' , $id)->firstOrFail();
        $freelancer = $bill->freelancer ;
        if (!$freelancer->is_active or
            $freelancer->offline or
            \Illuminate\Support\Carbon::now()->gte($freelancer->expiration_date)) {
            return $this->apiResponse(200, ['data' => ['bill' => $bill, 'Url' => "" , 'siteUrl' => "" , 'token' => "" , "can_pay" => false , 'why_not' => [
                'is_active' => !$freelancer->is_active,
                'is_offline' => $freelancer->offline,
                'package_expire' => \Illuminate\Support\Carbon::now()->gte($freelancer->expiration_date),
            ]], 'message' => [trans('api.FreelancerDeactivate')]]);
        }
        $today = Carbon::createFromFormat('Y-m-d H:i:s', Date('Y-m-d').' 00:00:00');
        if ( $bill->payment_status == "waiting" and  $bill->expire_at->gte($today) ){

            // Initialize the Payment request encryption/decryption library using the Secret Key and IV Key from the configuration
            $paymentHandler = new PaymentHandler($this->paymentApiUrl, $this->merchantCode, $this->secretKey, $this->ivKey, $this->accessCode);
            // Getting the payment data into request object
            $requestData = $this->modelBindingHelper->getCheckoutRequestData(array('amount' => $bill->amount, 'order_id' => $bill->id, 'order_track' => $bill->order_track, 'freelancer_id' => null, 'type' => 'bill'));

            // POST the requested object to the checkout API and receive back the response
            $response = $paymentHandler->checkoutRequest($requestData);

            //Get encrypted and decrypted checkout data response
            [$encryptedResponse, $hesabeCheckoutResponseModel] = $this->getCheckoutResponse($response);

            // check the response and validate it
            if ($hesabeCheckoutResponseModel->status == false && $hesabeCheckoutResponseModel->code != Constants::SUCCESS_CODE) {
                return $this->apiResponse(200, ['data' => ['bill' => $bill , 'Url' => "", 'siteUrl' => "" , 'token' => "" , "can_pay" => false, 'why_not' => [
                    'payment_status' => $hesabeCheckoutResponseModel->status ,
                    'payment_code' => $hesabeCheckoutResponseModel->code,
                ]], 'message' => [trans('api.canNotMakeLink')]]);
            }

            $token = $hesabeCheckoutResponseModel->response['data'];
            return $this->apiResponse(200, ['data' => [
                'bill' => $bill,
                'Url' => $this->paymentApiUrl . '/payment?data=' . $token,
                'siteUrl' => route('payment.showBill',['uuid' => $bill]),
                'token' => $token ,
                "can_pay" => true
            ], 'message' => [trans('api.billMade')]]);
        }
            
        return $this->apiResponse(200, ['data' => ['bill' => $bill, 'Url' => "" , 'siteUrl' => "" , 'token' => "" , "can_pay" => false,
            'why_not' => [
                'bill_status' => $bill->payment_status ,
                'bill_expire' => $bill->expire_at->gte($today),
            ]], 'message' => [trans('api.success')]]);
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
