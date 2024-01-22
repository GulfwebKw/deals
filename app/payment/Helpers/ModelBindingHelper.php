<?php
namespace App\payment\Helpers;
use App\payment\Misc\Constants;
use App\payment\Models\HesabeCheckoutRequestModel;
use App\payment\Models\HesabeCheckoutResponseModel;
use App\payment\Models\HesabePaymentResponseModel;
use Carbon\Carbon;

/**
 * This class is used to bind models
 *
 * @author Hesabe
 */
class ModelBindingHelper
{
    public $hesabeCheckoutResponseModel;
    public $hesabePaymentResponseModel;
    public $hesabeCheckoutRequestModel;

    public function __construct()
    {
        $this->hesabeCheckoutRequestModel = new HesabeCheckoutRequestModel();
        $this->hesabeCheckoutResponseModel = new HesabeCheckoutResponseModel();
        $this->hesabePaymentResponseModel = new HesabePaymentResponseModel();
    }

    /**
     * This function is use to bind the request data into class object
     *
     * @param array $request form post data
     *
     * @return object
     */
    public function getCheckoutRequestData($request)
    {
        
        $this->hesabeCheckoutRequestModel->amount = $request['amount'];
        $this->hesabeCheckoutRequestModel->variable1 = $request['order_id'];
        $this->hesabeCheckoutRequestModel->variable2 = $request['order_track'];
        $this->hesabeCheckoutRequestModel->variable3 = $request['freelancer_id'];
        $this->hesabeCheckoutRequestModel->variable4 = $request['type'];
        $this->hesabeCheckoutRequestModel->currency = 'KWD';
        $this->hesabeCheckoutRequestModel->paymentType = '1';
        $this->hesabeCheckoutRequestModel->orderReferenceNumber = Carbon::now()->toDateTimeString();
        $this->hesabeCheckoutRequestModel->version = '2.0';
        $this->hesabeCheckoutRequestModel->merchantCode = \App\payment\Misc\Constants::MERCHANT_CODE;
        $this->hesabeCheckoutRequestModel->responseUrl = route('payment.success');
        $this->hesabeCheckoutRequestModel->failureUrl = route('payment.fail');
       
        return $this->hesabeCheckoutRequestModel;
    }

    /**
     * Get Checkout response data.
     *
     * @param array $data Checkout response data
     *
     * @return object \Models\HesabeCheckoutResponseModel.
     */
    public function getCheckoutResponseData($data)
    {
        $this->hesabeCheckoutResponseModel->status = $data['status'];
        $this->hesabeCheckoutResponseModel->code = $data['code'];
        $this->hesabeCheckoutResponseModel->message = $data['message'];
        $this->hesabeCheckoutResponseModel->response['data'] = ($data['code'] == Constants::SUCCESS_CODE ||
         $data['code'] == Constants::AUTHENTICATION_FAILED_CODE) ? $data['response']['data'] : $data['data'];

        return $this->hesabeCheckoutResponseModel;
    }

    /**
     * Get Payment Response response data.
     *
     * @param array $data payment response data
     *
     * @return object \Models\HesabeCheckoutResponseModel.
     */
    public function getPaymentResponseData($data)
    {
        $this->hesabeCheckoutResponseModel->status = $data['status'];
        $this->hesabeCheckoutResponseModel->code = $data['code'];
        $this->hesabeCheckoutResponseModel->message = $data['message'];

        $this->hesabePaymentResponseModel->resultCode = $data['response']['resultCode'];
        $this->hesabePaymentResponseModel->amount = $data['response']['amount'];
        $this->hesabePaymentResponseModel->paymentToken = $data['response']['paymentToken'];
        $this->hesabePaymentResponseModel->paymentId = $data['response']['paymentId'];
        $this->hesabePaymentResponseModel->paidOn = $data['response']['paidOn'];
        $this->hesabePaymentResponseModel->orderReferenceNumber = $data['response']['orderReferenceNumber'];
        $this->hesabePaymentResponseModel->variable1 = $data['response']['variable1'];
        $this->hesabePaymentResponseModel->variable2 = $data['response']['variable2'];
        $this->hesabePaymentResponseModel->variable3 = $data['response']['variable3'];
        $this->hesabePaymentResponseModel->variable4 = $data['response']['variable4'];
        $this->hesabePaymentResponseModel->variable5 = $data['response']['variable5'];
        $this->hesabePaymentResponseModel->method = $data['response']['method'];
        $this->hesabePaymentResponseModel->administrativeCharge = $data['response']['administrativeCharge'];

        //Get Payment response array.
        $this->hesabeCheckoutResponseModel->response = $this->hesabePaymentResponseModel->getVariables();
        return $this->hesabeCheckoutResponseModel;
    }
}
