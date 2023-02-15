<?php

namespace App\Http\Controllers;

use App\City;
use App\Country;
use App\Message;
use App\NotifyEmail;
use App\Order;
use App\Package;

use App\Singlepage;
use App\Subject;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Settings;

//email
use App\Mail\SendGrid;




class WebController extends Controller
{
    public function home()
    {
        $title = "Home";
        $settings = Settings::where("keyname", "setting")->first();
        $packages = Package::all();
        return view('website.pages.home', compact('title', 'settings', 'packages'));
    }


    public function subscribe($code)
    {
        $title = "Subscribe";
        $settings = Settings::where("keyname", "setting")->first();
        $countries = Country::where('is_active',1)->get();
        return view('website.pages.subscribe', compact('title', 'settings', 'countries', 'code'));
    }


    public function getCountryCities(Request $request)
    {

        if (! empty($request->country_id)){
            $countryId = $request->country_id;
            $country = Country::find($countryId);
            if ($country){
                $cities = $country->cities;
                $response = "<option value='' >Select City</option>";
                foreach ($cities as $city){
                    $response .= "<option value='" . $city->id . "'>" . $city->title_en . "</option>";
                }
                return response()->json([$response]);
            }
        }
    }

    public function getCountryCitiesEdit(Request $request)
    {
        if (! empty($request->country_id)){
            $countryId = $request->country_id;
            $country = Country::find($countryId);
            if ($country){
                $cities = $country->cities;
                $response = "<option>Select City</option>";
                foreach ($cities as $city){
                    if ($city->id==$request->id){

                    $response .= "<option value='" . $city->id . "'>" . $city->title_en . "</option>";
                    }else{
                    $response .= "<option value='" . $city->id . "'>" . $city->title_en . "</option>";
                    }
                }
                return response()->json([$response]);
            }
        }
    }

    public function getAreas(Request $request)
    {

        if (! empty($request->city_id)){
            $cityId = $request->city_id;
            $city = City::find($cityId);
            if ($city){
                $areas = $city->areas;
                $response = "<option value='' >Select Area</option>";
                foreach ($areas as $area){
                    $response .= "<option  value='" . $area->id . "'>" . $area->title_en . "</option>";
                }
                return response()->json([$response]);
            }
        }
    }


    public function pay(Request $request)
    {
        //retrieving package
        $package = Package::where('code', $request->code)->first();

        //creating the order
        $order = new Order();
        $order->order_track = substr(time(), 5, 4) . rand(1000, 9999);
        $order->package_id = $package->id;
        $order->fname = $request->firstname;
        $order->lname = $request->lastname;
        $order->email = $request->email;
        $order->country_code = $request->countrycode;
        $order->phone = $request->phone;
        $order->mobile = $request->mobile;
        $order->country_id = $request->country;
        $order->city_id = $request->city;
        $order->block = $request->block;
        $order->street = $request->street;
        $order->avenue = $request->avenue;
        $order->house = $request->house;
        $order->flat = $request->flat;
        $order->amount = $package->price;
        $order->order_status = "pending";
        $order->payment_status = "notpaid";
        $order->save();

        $response = \App\Http\Controllers\Common::knetPaymentProcessing($order->id, $order->order_track, $package->price);
        if ($response['status'] == 1){
            $payUrl = $response['payurl'];
            return redirect($payUrl);
        }
        else{
            dd($response['message']);
        }
    }


    public function knetResponse(Request $request)
    {
        $errorText = $request->ErrorText; 	//Error Text/message
        $errorNo = $request->Error;          //Error Number
        $paymentId = $request->paymentid;	//Payment Id
        $result =  $request->result;         //Transaction Result
        $trackId = $request->trackid;        //Merchant Track ID
        $postDate = $request->postdate;      //Postdate
        $tranId = $request->tranid;          //Transaction ID
        $auth = $request->auth;              //Auth Code
        $avr = $request->avr;                //TRANSACTION avr
        $ref = $request->ref;                //Reference Number also called Seq Number
        $amount = $request->amt;             //Transaction Amount
        $udf1 = $request->udf1;              //UDF1
        $udf2 = $request->udf2;              //UDF2
        $udf3 = $request->udf3;              //UDF3
        $udf4 = $request->udf4;              //UDF4
        $udf5 = $request->udf5;              //UDF5

        // getting the terminal resource key
        $gateway = env('GATEWAY');
        if($gateway == "test"){$TERM_RESOURCE_KEY = config('services.knet_test.TERM_RESOURCE_KEY');}
        else{$TERM_RESOURCE_KEY = config('services.knet_live.TERM_RESOURCE_KEY');}

        if($errorText == null && $errorNo == null)
        {
            $tranData= $request->trandata;
            if($tranData != null)
            {
                $decrytedData = \App\Http\Controllers\Common::decrypt($tranData,$TERM_RESOURCE_KEY);
                $decrytedData = \App\Http\Controllers\Common::splitData($decrytedData);
                return redirect()->route('knetStatus', $decrytedData);
            }
        }
        else
        {
            return redirect()->route('knetStatus', [
                'ErrorText' => $errorText,
                'trackid' => $trackId,
                'amt' => $amount,
                'paymentid' => $paymentId
            ]);
        }
    }


    public function knetStatus(Request $request)
    {
        $result = ($request->result) ?: '';
        $paymentId = ($request->paymentid) ?: '';
        $trackId = ($request->trackid) ?: '';
        $auth = ($request->auth) ?: '';
        $avr = ($request->avr) ?: '';
        $ref = ($request->ref) ?: '';
        $tranId = ($request->tranid) ?: '';
        $postDate = ($request->postdate) ?: '';
        $amount = ($request->amt) ?: '';
        $error = ($request->ErrorText) ?: '';

        $order = Order::where('order_track', $trackId)->first();
        $transaction = Transaction::where('trackid', $trackId)->first();

        if ($result == 'CAPTURED'){
            //updating order
            $order->order_status = 'completed';
            $order->payment_status = 'paid';
            $order->save();

            //updating transaction
            $transaction->paymentid = $paymentId;
            $transaction->presult = $result;
            $transaction->tranid = $tranId;
            $transaction->auth = $auth;
            $transaction->ref = $ref;
            $transaction->postdate = $postDate;
            $transaction->avr = $avr;
            $transaction->payment_status = "paid";
            $transaction->save();
        }

        $title = "Transaction Response";
        $menuTitle = "Transaction Response";
        $settings = Settings::where("keyname", "setting")->first();

        return view('website.pages.transactionResult', compact('title', 'menuTitle', 'settings', 'result', 'trackId', 'paymentId', 'amount', 'error'));
    }


    public function about()
    {
        $title = "About Us";
        $about = Singlepage::where('slug','about-us')->first();
        $settings = Settings::where("keyname", "setting")->first();

        return view('website.pages.about', compact('title', 'about', 'settings'));
    }


    public function trackorder(Request $request)
    {
        if (isset($request->trackid)){
            $order = Order::where('order_track', $request->trackid)->first();
            if ($order){
                $transaction = Transaction::where('trackid', $request->trackid)->first();
                $package = $order->package;
            }
            else{
                $order = null;
                $transaction = null;
                $package = null;
            }
        }
        else{
            $order = null;
            $transaction = null;
            $package = null;
        }

        $title = "Order Track";
        $settings = Settings::where("keyname", "setting")->first();

        return view('website.pages.trackorder', compact('title', 'settings', 'order', 'transaction', 'package'));
    }


    public function contact()
    {
        $title = "Contact Us";
        $settings = Settings::where("keyname", "setting")->first();
        $subjects = Subject::where('is_active',1)->get();

        return view('website.pages.contact', compact('title', 'settings', 'subjects'));
    }


    public function contactSubmit(Request $request)
    {
        $settings = Settings::where("keyname", "setting")->first();

        $validator = Validator::make($request->all(),
            [
                'name' => 'required',
                'email' => 'required|email',
                'subject' => 'required',
                'message' => 'required|string|max:900',
                'captcha' => 'required|captcha'
            ],
            [
                'name.required' => trans('webMessage.name_required'),
                'email.required' => trans('webMessage.email_required'),
                'subject.required' => trans('webMessage.subject_required'),
                'message.required' => trans('webMessage.message_required'),
                'captcha.required' => trans('webMessage.captcha_required')
            ]
        );
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $message = new Message();
        $message->name = $request->input('name');
        $message->email = $request->input('email');
        $message->subject = $request->input('subject');
        $message->message = $request->input('message');
        $message->cip = $_SERVER['REMOTE_ADDR'];
        $message->save();

        //send email notification
        if (!empty($request->input('email'))) {
            $data = [
                'dear' => trans('webMessage.dear') . ' ' . $request->input('name'),
                'footer' => trans('webMessage.email_footer'),
                'message' => trans('webMessage.contactus_body'),
                'subject' => self::getSubjectName($request->input('subject')),
                'email_from' => $settings->from_email,
                'email_from_name' => $settings->from_name
            ];
            Mail::to($request->input('email'))->send(new SendGrid($data));
        }

        $emails = NotifyEmail::where('is_active',1)->get();
        if (!empty($emails)) {
            $appendMessage = "";
            $appendMessage .= "<br><b>" . trans('webMessage.name') . " : </b>" . $request->input('name');
            $appendMessage .= "<br><b>" . trans('webMessage.email') . " : </b>" . $request->input('email');
            $appendMessage .= "<br><b>" . trans('webMessage.subject') . " : </b>" . self::getSubjectName($request->input('subject'));
            $appendMessage .= "<br><b>" . trans('webMessage.message') . " : </b>" . $request->input('message');
            $dataadmin = [
                'dear' => trans('webMessage.dearadmin'),
                'footer' => trans('webMessage.email_footer'),
                'message' => trans('webMessage.contactus_admin_body') . "<br><br>" . $appendMessage,
                'subject' => self::getSubjectName($request->input('subject')),
                'email_from' => $settings->from_email,
                'email_from_name' => $settings->from_name
            ];
            foreach ($emails as $email){
                Mail::to($email)->send(new SendGrid($dataadmin));
            }
        }

        return back()->with('session_msg', trans('webMessage.contact_message_sent'));
    }


    public function refreshCaptcha()
    {
        return response()->json(['captcha' => captcha_img('flat')]);
    }


    // get settings data
    public static function settings()
    {
        return Settings::where("keyname", "setting")->first();
    }


    // get single page data
    public static function getSinglePage($keyname)
    {
        return Singlepage::where("is_active", "1")->where('slug', $keyname)->first();
    }


    // get subject of the message (contact us page)
    public static function getSubjectName($subjectid)
    {
        $recDetails = Subject::where('id', $subjectid)->first();
        return !empty($recDetails['title_en']) ? $recDetails['title_en'] : 'Contact';
    }

}
