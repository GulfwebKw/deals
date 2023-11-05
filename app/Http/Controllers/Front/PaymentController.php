<?php

namespace App\Http\Controllers\Front;

use App\Discount;
use App\Freelancer;
use App\FreelancerNotification;
use App\FreelancerWorkshop;
use App\Http\Controllers\Admin\webPushController;
use App\Mail\SendGrid;
use App\Order;
use App\Package;
use App\payment\Helpers\ModelBindingHelper;
use App\payment\Lib\HesabeCrypt;
use App\payment\Misc\Constants;
use App\payment\Misc\PaymentHandler;
use App\payment\Models\HesabeCheckoutResponseModel;
use App\PushDevices;
use App\QuotationOrder;
use App\UserOrder;
use App\Settings;
use App\WebPushMessage;
use App\WorkshopOrder;
use App\Bill;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/**
 * This Class handles the form request to the checkout controller
 * and receive the response and displays the encrypted and decrypted data.
 *
 * @author Hesabe
 */
class PaymentController
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
     * This function handles the form request and get the response
     *
     * @return void
     */
    public function formSubmit(Request $request)
    {
        $discount = Discount::query()->find($request->get('discount_id' , 0));
        if ( $discount and ! $discount->is_active )
            return redirect()->back()->withInput()->withErrors('Discount code is invalid!');
        if ( $discount and ! $discount->hasExpired )
            return redirect()->back()->withInput()->withErrors('Discount code is expired!');
        $package = Package::find($request->id);
        //creating the order
        $order = new Order();
        $order->order_track = substr(time(), 5, 4) . rand(1000, 9999);
        $order->package_id = $package->id;
        $order->freelancer_id = Auth::id();
        $order->amount = $discount ? $discount->convertPrice($package->price)  : $package->price;
        if ( $order->amount <= 0 ) {
            $freelancer = $this->packageBooking($order->package_id, $order->freelancer_id);
            $order->payment_status = 'paid';
            $order->order_status = 'paid';
            $order->save();
            $discount->used = $discount->used + 1;
            $discount->save();
            $settings = Settings::where("keyname", "setting")->first();
            $data = [
                'dear' => trans('webMessage.dear') . ' ' . $freelancer->name,
                'footer' => trans('webMessage.email_footer'),
                'message' => trans('webMessage.buyPackageEmail').'Date : ' .$order->created_at->format('Y-m-d') . '<br>Transaction Status : Successful<br>Trasaction Track Id : '.$order->order_track.'<br>Payment Method : Knet<br>Amount : KD '.$order->amount,
                'subject' => 'Payment details of '.$settings->name_en ,
                'email_from' => env('MAIL_USERNAME' , $settings->from_email),
                'email_from_name' => $settings->from_name
            ];
            \Illuminate\Support\Facades\Mail::to($freelancer->email)->send(new SendGrid($data));
            return redirect()->back();
        }
        $order->order_status = "pending";
        $order->payment_status = "notpaid";
        $order->save();

        // Initialize the Payment request encryption/decryption library using the Secret Key and IV Key from the configuration
        $paymentHandler = new PaymentHandler($this->paymentApiUrl, $this->merchantCode, $this->secretKey, $this->ivKey, $this->accessCode);

        // Getting the payment data into request object
        $requestData = $this->modelBindingHelper->getCheckoutRequestData(array('amount' => $order->amount, 'order_id' => $order->id, 'order_track' => $order->order_track, 'freelancer_id' => $order->freelancer_id, 'type' => 'package'));

        // POST the requested object to the checkout API and receive back the response
        $response = $paymentHandler->checkoutRequest($requestData);
        //Get encrypted and decrypted checkout data response
        [$encryptedResponse, $hesabeCheckoutResponseModel] = $this->getCheckoutResponse($response);

        // check the response and validate it
        if ($hesabeCheckoutResponseModel->status == false && $hesabeCheckoutResponseModel->code != Constants::SUCCESS_CODE) {
            echo "<p style='word-break: break-all;'> <b>Encrypted Data</b>:- " . $encryptedResponse . "</p>";
            echo "<p><b>Decrypted Data</b>:- </p>";
            echo "<pre>";
            print_r($hesabeCheckoutResponseModel);
            exit;
        }

        // Redirect the user to the payment page using the token from the checkout API response
        return $this->redirectToPayment($hesabeCheckoutResponseModel->response['data']);

        /*
         * To use this method, make sure your SuccessUrl or FailureUrl
         * points to this method in which you'll receive a "data" param
         * as a GET request. Then you can process it accordingly.
         */
        if (isset($_GET['id']) && isset($_GET['data'])) {
            $responseData = $_GET['data'];

            //Decrypt the response received
            $decryptedResponse = $this->getPaymentResponse($responseData);

            echo "<p style='word-break: break-all;'> Encrypted Data:- " . $responseData . "</p>";
            echo "<p><b>Decrypted Data</b>:- </p>";
            echo "<pre>";
            print_r($decryptedResponse);
            exit;
        }
    }


    public function QuotationFormSubmit(Request $request)
    {
        $package = Package::find($request->id);
        //creating the order
        $order = new Order();
        $order->order_track = substr(time(), 5, 4) . rand(1000, 9999);
        $order->package_id = $package->id;
        $order->freelancer_id = Auth::id();
        $order->amount = $package->price;
        $order->order_status = "pending";
        $order->payment_status = "notpaid";
        $order->save();

        // Initialize the Payment request encryption/decryption library using the Secret Key and IV Key from the configuration
        $paymentHandler = new PaymentHandler($this->paymentApiUrl, $this->merchantCode, $this->secretKey, $this->ivKey, $this->accessCode);

        // Getting the payment data into request object
        $requestData = $this->modelBindingHelper->getCheckoutRequestData(array('amount' => $order->amount, 'order_id' => $order->id, 'order_track' => $order->order_track, 'freelancer_id' => $order->freelancer_id, 'type' => 'package'));

        // POST the requested object to the checkout API and receive back the response
        $response = $paymentHandler->checkoutRequest($requestData);
        //Get encrypted and decrypted checkout data response
        [$encryptedResponse, $hesabeCheckoutResponseModel] = $this->getCheckoutResponse($response);

        // check the response and validate it
        if ($hesabeCheckoutResponseModel->status == false && $hesabeCheckoutResponseModel->code != Constants::SUCCESS_CODE) {
            echo "<p style='word-break: break-all;'> <b>Encrypted Data</b>:- " . $encryptedResponse . "</p>";
            echo "<p><b>Decrypted Data</b>:- </p>";
            echo "<pre>";
            print_r($hesabeCheckoutResponseModel);
            exit;
        }

        // Redirect the user to the payment page using the token from the checkout API response
        return $this->redirectToPayment($hesabeCheckoutResponseModel->response['data']);
        /*
         * To use this method, make sure your SuccessUrl or FailureUrl
         * points to this method in which you'll receive a "data" param
         * as a GET request. Then you can process it accordingly.
         */
        if (isset($_GET['id']) && isset($_GET['data'])) {
            $responseData = $_GET['data'];

            //Decrypt the response received
            $decryptedResponse = $this->getPaymentResponse($responseData);

            echo "<p style='word-break: break-all;'> Encrypted Data:- " . $responseData . "</p>";
            echo "<p><b>Decrypted Data</b>:- </p>";
            echo "<pre>";
            print_r($decryptedResponse);
            exit;
        }
    }

    /**
     * Redirect to payment gateway to complete the process
     *
     * @param string $token Encrypted data
     *
     * @return null [<description>]
     */
    public function redirectToPayment($token)
    {
        header("Location: $this->paymentApiUrl/payment?data=$token");
        exit;
    }

    /**
     * Process the response after the transaction is complete
     *
     * @return array De-serialize the decrypted response
     *
     */
    public function getPaymentResponse($responseData)
    {
        //Decrypt the response received in the data query string
        $decryptResponse = $this->hesabeCrypt::decrypt($responseData, $this->secretKey, $this->ivKey);

        //De-serialize the decrypted response
        $decryptResponseData = json_decode($decryptResponse, true);
        //Binding the decrypted response data to the entity model
        $decryptedResponse = $this->modelBindingHelper->getPaymentResponseData($decryptResponseData);

        //return decrypted data
        return $decryptedResponse;
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

    public function success(Request $request)
    {

        $responseData = $request->data;
        $decryptedResponse = $this->getPaymentResponse($responseData);
        $data = $decryptedResponse->response;

        if ($data['resultCode'] == 'CAPTURED') {
            if ($data['variable4'] == 'package') {
                $order = order::find($data['variable1']);
                if ( $order->status == null ) {
                    $freelancer = $this->packageBooking($order->package_id, $data['variable3']);
                    $order->status = $decryptedResponse->status;
                    $order->payment_id = $data['paymentId'];
                    $order->result = $data['resultCode'];
                    $order->payment_status = 'paid';
                    $order->order_status = 'paid';
                    $order->error = $decryptedResponse->message;
                    $order->save();
                    $settings = Settings::where("keyname", "setting")->first();
                    $data = [
                        'dear' => trans('webMessage.dear') . ' ' . $freelancer->name,
                        'footer' => trans('webMessage.email_footer'),
                        'message' => trans('webMessage.buyPackageEmail').'Date : ' .$order->created_at->format('Y-m-d') . '<br>Transaction Status : Successful<br>Trasaction Track Id : '.$order->order_track.'<br>Payment Method : Knet<br>Amount : KD '.$order->amount,
                        'subject' => 'Payment details of '.$settings->name_en ,
                        'email_from' => env('MAIL_USERNAME' , $settings->from_email),
                        'email_from_name' => $settings->from_name
                    ];
                    \Illuminate\Support\Facades\Mail::to($freelancer->email)->send(new SendGrid($data));
                }
            } elseif ($data['variable4'] == 'service') {
                $order = UserOrder::find($data['variable1']);
                if ( $order->payment_status == "waiting" ) {
                    $services = $order->services()->get();
                    $sentFreelancerId = [];
                    foreach ($services as $service) {
                        $timeSlot = $service->timeSlot;
                        if ( $timeSlot != null ) {
                            $timeSlot->status = 'booked';
                            $timeSlot->save();
                        }
                        $service->status = 'booked';
                        $service->save();
                        if ( ! in_array($service->freelancer_id , $sentFreelancerId)){
                            FreelancerNotification::add($order->user_id,$service->freelancer_id,['bookingService' , $order->user->Fullname , $service->date .' '.$service->time ],'bookingService',['booking_id' => $service->id]);
                            $sentFreelancerId[] = $service->freelancer_id ;
                        }
                    }
                    $order->payment_id = $data['paymentId'];
                    $order->result = $data['resultCode'];
                    $order->payment_status = 'paid';
                    $order->error = $decryptedResponse->message;
                    $order->save();
                }
            } elseif ($data['variable4'] == 'create_workshop') {
                $order = FreelancerWorkshop::withoutGlobalScopes()->find($data['variable1']);
                if ( $order->is_approved == "pending_payment" ) {
                    $order->is_approved = "pending";
                    $order->payment_id = $data['paymentId'];
                    $order->result = $data['resultCode'];
                    $order->error = $decryptedResponse->message;
                    $order->save();
                    $order->amount = $order->creat_price;
                    $OTPTokens = PushDevices::where('device' , 'admin')->get()->pluck('token')->unique();
                    $WebPushs = new WebPushMessage;
                    $WebPushs->title = websiteName();
                    $WebPushs->message = 'New workshop pending for approve.';
                    $WebPushs->action_url = asset('gwc/workshops/approval');
                    webPushController::sendWebPushy($OTPTokens, $WebPushs );
                }
            } elseif ($data['variable4'] == 'workshop') {
                $order = WorkshopOrder::find($data['variable1']);
                if ( $order->payment_status == "waiting" ) {
                    $order->payment_id = $data['paymentId'];
                    $order->result = $data['resultCode'];
                    $order->payment_status = 'paid';
                    $order->error = $decryptedResponse->message;
                    $order->save();
                    FreelancerNotification::add($order->user_id,$order->workshop->freelancer_id,['workshopBooked' , $order->user->Fullname ],'workshopBooked',['workshop_id' => $order->workshop->id]);
                    if ( $order->workshop->available == 0 ){
                        FreelancerNotification::add($order->user_id,$order->workshop->freelancer_id,['bookingWorkshop' , '' , $order->workshop->date .' '.$order->workshop->from_time ],'bookingWorkshop',['workshop_id' => $order->workshop->id]);
                    }
                }
            } elseif ($data['variable4'] == 'bill') {
                $order = Bill::find($data['variable1']);
                if ( $order->payment_status == "waiting" ) {
                    $order->payment_id = $data['paymentId'];
                    $order->result = $data['resultCode'];
                    $order->payment_status = 'paid';
                    $order->error = $decryptedResponse->message;
                    $order->save();
                    FreelancerNotification::add($order->user_id, $order->freelancer_id, ['billPaid', $order->user->Fullname, now() , [ 'amount' => number_format($order->amount) , 'description' => $order->description ] ], 'billPaid', ['bill_uuid' => $order->uuid , 'bill_id' => $order->id]);
                }
            }
        }


        return view('front.transaction', compact('order'));
    }

    public function fail(Request $request)
    {
        $responseData = $request->data;
        $decryptedResponse = $this->getPaymentResponse($responseData);
        $data = $decryptedResponse->response;
        if ($data['resultCode'] != 'CAPTURED') {
            if ($data['variable4'] == 'package') {
                $order = order::find($data['variable1']);
                if ( $order->status == null ) {
                    $order->status = $decryptedResponse->status;
                    $order->payment_id = $data['paymentId'];
                    $order->result = $data['resultCode'];
                    $order->payment_status = 'failed';
                    $order->order_status = 'failed';
                    $order->error = $decryptedResponse->message;
                    $order->save();
                }
            } elseif ($data['variable4'] == 'service') {
                $order = UserOrder::find($data['variable1']);
                if ( $order->payment_status == "waiting" ) {
                    $order->payment_id = $data['paymentId'];
                    $order->result = $data['resultCode'];
                    $order->error = $decryptedResponse->message;
                    $order->save();
                }
            } elseif ($data['variable4'] == 'workshop') {
                $order = WorkshopOrder::find($data['variable1']);
                if ( $order->payment_status == "waiting" ) {
                    $order->payment_id = $data['paymentId'];
                    $order->result = $data['resultCode'];
                    $order->error = $decryptedResponse->message;
                    $order->save();
                }
            } elseif ($data['variable4'] == 'create_workshop') {
                $order = FreelancerWorkshop::find($data['variable1']);
                if ( $order->is_approved == "pending_payment" ) {
                    $order->payment_id = $data['paymentId'];
                    $order->result = $data['resultCode'];
                    $order->error = $decryptedResponse->message;
                    $order->save();
                }
            } elseif ($data['variable4'] == 'bill') {
                $order = Bill::find($data['variable1']);
                if ( $order->payment_status == "waiting" ) {
                    $order->payment_id = $data['paymentId'];
                    $order->result = $data['resultCode'];
                    $order->error = $decryptedResponse->message;
                    $order->save();
                }
            }
        }
        return view('front.transaction', compact('order'));
    }


    public function packageBooking($package_id, $freelancer_id)
    {
        $package = Package::find($package_id);
        $freelancer = Freelancer::find($freelancer_id);
        $freelancer->package_id = $package_id;
        $freelancer->expiration_date = Carbon::now()->addDays($package->duration)->toDateString();
        $freelancer->save();
        return $freelancer;
    }

    public function serviceBooking()
    {

    }


    public function showBill($uuid){
        $bill = Bill::where('uuid' , $uuid)->firstOrFail();
        $freelancer = $bill->freelancer ;
        if (!$freelancer->is_active or
            $freelancer->offline or
            \Illuminate\Support\Carbon::now()->gte($freelancer->expiration_date)) {
            abort(403);
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
                abort(500);
            }

            $token = $hesabeCheckoutResponseModel->response['data'];
            return redirect($this->paymentApiUrl . '/payment?data=' . $token);
        } else
            abort(403);
    }
}
