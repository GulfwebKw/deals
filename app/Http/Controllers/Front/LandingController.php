<?php

namespace App\Http\Controllers\Front;

use App\Category;
use App\Freelancer;
use App\FreelancerServices;
use App\HowItWork;
use App\Mail\SendGrid;
use App\Package;
use App\Rate;
use App\Settings;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LandingController extends Controller
{
    public function test()
    {
        $settings = Settings::where("keyname", "setting")->first();
        $order = \App\Order::inRandomOrder()->first();
        $data = [
            'dear' => trans('webMessage.dear') . ' erfan' ,
            'footer' => trans('webMessage.email_footer'),
            'message' => view('website.pageSections.transactionResult', compact('order'))->render(),
            'subject' => 'Payment details of '.$settings->name_en ,
            'email_from' => env('MAIL_USERNAME' , $settings->from_email),
            'email_from_name' => $settings->from_name
        ];
        \Illuminate\Support\Facades\Mail::to('adib@gulfclick.net')->send(new SendGrid($data));

    }

    public function setLocale($lang)
    {
        App::setLocale($lang);
        session()->put('locale', $lang);
        return redirect('/');
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'full_name' => 'required|string|max:255',
            'phonenumber' => 'required|numeric|unique:freelancers,phone',
            'email' => 'required|email|unique:freelancers,email|max:255',
            'username' => 'required|unique:freelancers,username',
            'password' => 'required|string|max:255',
            'password_confirmation' => 'required_with:password|same:password|min:6'
        ]);
        if ( $request->has('resend') ){
            $otp = rand(10000, 99999);
            $this->sendOtp($otp, $request->phonenumber,  $request->email, 'sms');
            \Illuminate\Support\Facades\Log::info('validation code for : '. $request->phonenumber . ' or '. $request->email . ' is '.$otp  );
            $request->merge(['codeValidation' => Hash::make($otp . " : ".$request->phonenumber ." : ".$request->email )]);
            return redirect()->back()->withInput()->with('success', 'Validation code resend to your mobile.');
        }
        if ( ! $request->has('code') ){
            $otp = rand(10000, 99999);
            $this->sendOtp($otp, $request->phonenumber,  $request->email, 'sms');
            \Illuminate\Support\Facades\Log::info('validation code for : '. $request->phonenumber . ' or '. $request->email . ' is '.$otp  );
            $request->merge(['codeValidation' => Hash::make($otp . " : ".$request->phonenumber ." : ".$request->email )]);
            return redirect()->back()->withInput()->with('success', 'Validation code send to your mobile.');
        } elseif ( ! Hash::check($request->code . " : ".$request->phonenumber ." : ".$request->email  , $request->codeValidation) )
            return redirect()->back()->withInput()->withErrors('Validation code is invalid.');


        $freelancer = Freelancer::create([
            'name'=>$request->full_name,
            'email'=>$request->email,
            'phone'=>$request->phonenumber,
            'username'=>$request->username,
            'password'=> Hash::make($request->password),
        ]);
        $rate = Rate::create([
           'number_people' => 0,
           'rate' => 0,
        ]);
        $settings = Settings::where("keyname", "setting")->first();
        $freelancer->service_commission_price = $settings->service_commission_price;
        $freelancer->service_commission_percent = $settings->service_commission_percent;
        $freelancer->service_commission_type = $settings->service_commission_type;

        $freelancer->workshop_commission_price = $settings->workshop_commission_price;
        $freelancer->workshop_commission_percent = $settings->workshop_commission_percent;
        $freelancer->workshop_commission_type = $settings->workshop_commission_type;

        $freelancer->bill_commission_price = $settings->bill_commission_price;
        $freelancer->bill_commission_percent = $settings->bill_commission_percent;
        $freelancer->bill_commission_type = $settings->bill_commission_type;
        $freelancer->rate_id = $rate->id;
        $freelancer->save();
        $data = [
            'dear' => trans('webMessage.dear') . ' ' . $freelancer->name,
            'footer' => trans('webMessage.email_footer'),
            'message' => trans('webMessage.welcomeEmail'),
            'subject' => 'Welcome to '.$settings->name_en ,
            'email_from' => env('MAIL_USERNAME' , $settings->from_email),
            'email_from_name' => $settings->from_name
        ];
        \Illuminate\Support\Facades\Mail::to($freelancer->email)->send(new SendGrid($data));
        return redirect('/')->with('success', 'Registration Successfully Done');
    }

    public function login(Request $request)
    {
        if (Auth::guard('freelancer')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            // if successful, then redirect to their intended location
                return redirect('/freelancer');
        }
        return redirect()->back()->withInput($request->only('username', 'remember'));
    }

    public function index()
    {

        $settings = Settings::where("keyname", "setting")->first();
        $categories = Category::where('parent_id', null)->get();
        $sliders = HowItWork::all();
        return view('front.index', compact('categories', 'sliders', 'settings'));
    }

    public function loginPage()
    {
        return view('front.login');
    }

    public function registerPage()
    {
        return view('front.register');
    }

    public function packages()
    {
        $packages = Package::all();
        $expire = \auth()->user()->expiration_date;
        return view('front.freelancerPackages', compact('packages', 'expire'));
    }

    public function logOut()
    {
        Auth::guard('freelancer')->logout();
        return redirect('/');
    }

    public function termsAndCondotopns()
    {
        return view('front.termConditions');
    }

    public function RefundPolicy()
    {
        return view('front.refundPolicy');
    }

}
