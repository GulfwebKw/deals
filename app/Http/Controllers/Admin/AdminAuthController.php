<?php

namespace App\Http\Controllers\Admin;


use App\Admin;
use App\Mail\SendGrid;
use App\Settings;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mail;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;


class AdminAuthController extends Controller
{
    use RedirectsUsers, ThrottlesLogins;


    public function __construct()
    {
        // middleware guest : RedirectIfAuthenticated
        // this middleware takes action for all of this class methods except logout
        // the middleware checks the user's guard
        // admin guard redirects to '/gwc/home'
        // user guard redirects to '/'
        $this->middleware('guest')->except('logout');
    }


    // username field
    public function username()
    {
        return 'username';
    }


    // if the user is not logged in, then will be redirected to login page
    public function index()
    {
        $settings = Settings::where("keyname", "setting")->first();
        return view('gwc.auth.login', ['settings' => $settings]);
    }


    //process login
    public function login(Request $request)
    {
        $this->validate($request, [
                'username' => 'required|min:4',
                'password' => 'required|min:6'
            ],
            [
                'username.required' => 'Please enter login username',
                'password.required' => 'Please enter login password'
            ]
        );

        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $remember = $request->remember ? true : false;

        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
            'is_active' => 1
        ];

        if (Auth::guard('admin')->attempt($credentials, $remember))
        {
            $request->session()->regenerate();

            $this->clearLoginAttempts($request);

            //save logs
            $key_name   = "login";
            $key_id     = Auth::guard('admin')->user()->id;
            $message    = Auth::guard('admin')->user()->name . " is logged in to Admin Panel.";
            $created_by = Auth::guard('admin')->user()->id;
            Common::saveLogs($key_name,$key_id,$message,$created_by);

            return redirect()->intended('/gwc/home/');
        }

        $this->incrementLoginAttempts($request);

        return back()->withInput()->withErrors(['invalidLogin'=>'Invalid login credentials']);
    }


    // Log the user out of the application.
    public function logout(Request $request)
    {
        //save logs
        $key_name   = "logout";
        $key_id     = Auth::guard('admin')->user()->id;
        $message    = Auth::guard('admin')->user()->name . " is logged out from Admin Panel.";
        $created_by = Auth::guard('admin')->user()->id;
        Common::saveLogs($key_name,$key_id,$message,$created_by);
        //end save logs

        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        //$request->session()->flush();
        //$request->session()->regenerate();

        return redirect('/gwc/')->with("info","You have successfully logged out from Admin Panel");
    }


    //view forgot password screen
    public function forgot()
    {
        $settings = Settings::where("keyname", "setting")->first();
        return view('gwc.auth.forgot', ['settings' => $settings]);
    }


    //send reset link to email when user forgot the password
    public function sendResetLinkEmail(Request $request)
    {
        //field validation
        $this->validate($request,
            [
                'email' => 'required|email'
            ],
            [
                'email.required' => 'Please enter your email',
            ]
        );

        $settings = Settings::where("keyname", "setting")->first();

        $admin = Admin::where("email", $request->email)->first();

        if (empty($admin->id)) {
            return redirect('/gwc/forgot')
                ->withErrors(['email' => trans('adminMessage.email_not_register')])
                ->withInput();
        }
        else {
            $token = (string)Str::uuid();
            $admin->password_token = $token;
            $admin->save();

            $appendMessage = "<b><a href='" . url('gwc/forgot/' . $token) . "'>" . trans('adminMessage.passwordresetlink') . "</b>";
            $data = [
                'dear' => trans('adminMessage.dear') . ' ' . $admin->name,
                'footer' => trans('adminMessage.email_footer'),
                'message' => trans('adminMessage.you_have_reqtest_fp') . "<br><br>" . $appendMessage,
                'subject' => 'Admin Forgot Password Reset Link',
                'email_from' => $settings->from_email,
                'email_from_name' => $settings->from_name
            ];
            Mail::to($request->email)->send(new SendGrid($data));

            //save logs
            $key_name = "forgot";
            $key_id = $admin->id;
            $message = $admin->name . " has requested a forgot password link.";
            $created_by = $admin->id;
            Common::saveLogs($key_name, $key_id, $message, $created_by);
            //end save logs

            return redirect('/gwc/forgot')
                ->with('info', trans('adminMessage.password_reset_link_sent'));
        }
    }


    //view forgot password screen
    public function showResetForm()
    {
        return view('gwc.auth.forgot');
    }


    // reset password
    public function resetPassword(Request $request, $token)
    {
        //field validation
        $this->validate($request,
            [
                'email' => 'required|email',
                'new_password' => 'required|min:3|max:150|string',
                'confirm_password' => 'required|min:3|max:150|string|same:new_password',
            ],
            [
                'email.required' => trans('adminMessage.email_required'),
                'new_password.required' => trans('adminMessage.new_password_required'),
                'confirm_password.required' => trans('adminMessage.confirm_password_required'),
                'confirm_password.same' => trans('adminMessage.confirm_password_mismatched'),
            ]
        );

        $settings = Settings::where("keyname", "setting")->first();

        $admin = Admin::where("email", $request->email)->where("password_token", $token)->first();

        if (empty($admin->id)) {
            return redirect('/gwc/forgot/' . $token)
                ->withErrors(['email' => trans('adminMessage.email_not_register_or_token')])
                ->withInput();
        }
        else {
            $token = (string)Str::uuid();
            $admin->password_token = $token;
            $admin->password = bcrypt($request->new_password);
            $admin->save();

            $appendMessage = "";
            $appendMessage .= "<b>" . trans('adminMessage.username') . " : </b>" . $admin->username;
            $appendMessage .= "<br><b>" . trans('adminMessage.password') . " : </b>" . $request->new_password;
            $data = [
                'dear' => trans('adminMessage.dear') . ' ' . $admin->name,
                'footer' => trans('adminMessage.email_footer'),
                'message' => trans('adminMessage.password_reset_done_success') . "<br><br>" . $appendMessage,
                'subject' => 'Admin Password Successfully Reset',
                'email_from' => $settings->from_email,
                'email_from_name' => $settings->from_name
            ];
            Mail::to($request->email)->send(new SendGrid($data));

            //save logs
            $key_name = "forgot";
            $key_id = $admin->id;
            $message = $admin->name . " has reset his old password";
            $created_by = $admin->id;
            Common::saveLogs($key_name, $key_id, $message, $created_by);
            //end save logs

            return redirect('/gwc')
                ->with('info', trans('adminMessage.password_reset_done'));
        }
    }

}