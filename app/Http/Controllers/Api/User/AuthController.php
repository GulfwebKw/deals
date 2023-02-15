<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use App\Http\Controllers\Admin\Common;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
        public $image_big_w = 0;
    public $image_big_h = 0;
    public $image_thumb_w = 128;
    public $image_thumb_h = 128;
    public $path = "users";

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email_mobile' => 'required',
            'password' => 'required|string',
        ]);
        if ($validator->fails()) {
            return $this->apiResponse(422, ['data' => [], 'message' => $validator->errors()->all()]);
        }
        $is_email = $this->checkEmail($request->email_mobile);
        if ($is_email) {
            if (!auth('user')->attempt(['email' => $request->email_mobile, 'password' => $request->password], $request->remember))
                return $this->apiResponse(403, ['data' => [], 'message' => [trans('api.incorrectLogin')]]);
        } else {
            if (!auth('user')->attempt(['mobile' => $request->email_mobile, 'password' => $request->password], $request->remember))
                return $this->apiResponse(403, ['data' => [], 'message' => [trans('api.incorrectLogin2')]]);
        }
        $user = Auth::guard('user')->user();
        if ($user->otp_verified==0){
            $userOtp = $user->OTP ;
            if ($userOtp == null ) {
                $otp = rand(10000, 99999);
                $userOtp = $user->otp()->create(['code' => $otp]);
            }
            $result = $this->sendOtp($userOtp->code, $user->mobile , $user->email , 'sms');
            $user = $user->toArray();
            unset($user['o_t_p']);
            if ($result)
                return $this->apiResponse(200, ['data' => [
                        'access_token' => "",
                        'token_type' => 'Bearer',
                        'expires_at' => Carbon::now()->toDateTimeString(),
                        'user' => $user,
                    ], 'message' => [trans('api.otpRequired')]]);
            else
                return $this->apiResponse(400, ['data' => [], 'message' => [trans('api.unknownError')]]);
            
        }
        if (  $request->has('token')  )
            $user->pushNotification()->create([
                'device' => $request->has('device') ? $request->device : 'unknown',
                'token' => $request->token,
            ]);

        $tokenResult = $user->createToken('freelancer Personal Access Token');
        $token = $tokenResult->token;
        $token->expires_at = Carbon::now()->addMonths(3);
        $token->save();
        return $this->apiResponse(200, ['data' => [
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString(),
            'user' => $user,
        ], 'message' => [trans('api.LoginSuccessfully')]]);
    }

    public function getDetails(Request $request)
    {
        $token = str_replace("Bearer " , "" , $request->header('Authorization'));
        $user = User::find(Auth::id());
        return $this->apiResponse(200, ['data' => [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::now()->toDateTimeString(),
            'user' => $user,
        ], 'message' => [trans('api.success')]]);

//        $user = User::with('address')->find(Auth::id());
//        return $this->apiResponse(200, ['data' => ['user' => $user], 'message' => [trans('api.success')]]);
    }

    private function checkEmail($email)
    {
        $find1 = strpos($email, '@');
        $find2 = strpos($email, '.');
        return ($find1 !== false && $find2 !== false);
    }

    public function logoutApi(Request $request)
    {
        $user = Auth::user();
        if ( $request->has('token') )
            $user->pushNotification()->where('token' , $request->token )->delete();
        $user->AauthAcessToken()->delete();
        return $this->apiResponse(200, ['data' => [], 'message' => [trans('api.LogoutSuccessfully')]]);
    }


    public function sendOtpChangePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email_mobile' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->apiResponse(422, ['data' => [], 'message' => $validator->errors()->all()]);
        }
        $user = User::where('mobile', $request->email_mobile)->orWhere('email', $request->email_mobile)->first();
        if (!isset($user)) {
            return $this->apiResponse(404, ['data' => [], 'message' => [trans('api.UserNotExist')]]);
        }
        $userOtp = $user->OTP ;
        if ($userOtp == null ) {
            $otp = rand(10000, 99999);
            $userOtp = $user->otp()->create(['code' => $otp]);
        }
        $result = $this->sendOtp($userOtp->code, $user->mobile,  $user->email, 'email' );
        if ($result != "ok") {
            return $this->apiResponse(422, ['data' => [], 'message' => [trans('api.success')]]);
        } else
            return $this->apiResponse(200, ['data' => [], 'message' => [$result]]);
    }


    public function sendOTPToUser(Request $request)
    {
        if ( ! $request->has('type') )
            $request->merge(['type' => 'email']);
        $user = Auth::user();
        $userOtp = $user->OTP ;
        if ($userOtp == null ) {
            $otp = rand(10000, 99999);
            $userOtp = $user->otp()->create(['code' => $otp]);
        }
        $result = $this->sendOtp($userOtp->code, $user->mobile,  $user->email, $request->type );

        if ($result != "ok") {
            return $this->apiResponse(422, ['data' => [], 'message' => [trans('api.success')]]);
        } else
            return $this->apiResponse(200, ['data' => [], 'message' => [$result]]);
    }

    public function codeValidation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email_mobile' => 'required',
            'code' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->apiResponse(422, ['data' => [], 'message' => $validator->errors()->all()]);
        }

        $user = User::where(function ($query) use($request){
            $query->where('mobile', $request->email_mobile)
                ->orWhere('email', $request->email_mobile);
        })->where('otp_verified' , 0)->first();
        if ( $user == null )
            return $this->apiResponse(422, ['data' => [], 'message' => [trans('api.incorrectMobile')]]);


        $userOtp = $user->OTP ;
        if (isset($userOtp) && $userOtp->code == $request->code) {
            $user->update(['otp_verified'=>1]);
            $userOtp->delete();
            $tokenResult = $user->createToken('freelancer Personal Access Token');
            $user = $user->toArray();
            unset($user['o_t_p']);
            return $this->apiResponse(200, ['data' => ['access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString(),
                'user' => $user], 'message' => [trans('api.LoginSuccessfully')]]);
        } else
            return $this->apiResponse(422, ['data' => [], 'message' => [trans('api.IncorrectCode')]]);
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email_mobile' => 'required',
            'code' => 'required',
            'password' => 'required',
            'password_confirmation' => 'required_with:password|same:password|min:6'
        ]);
        if ($validator->fails()) {
            return $this->apiResponse(422, ['data' => [], 'message' => $validator->errors()->all()]);
        }
        $user = User::query()->where('email', $request->email_mobile)->orWhere('mobile', $request->email_mobile)->first();
        $code = $user->OTP ;
        if (isset($user) && $code != null) {
            if (isset($code->code) && $code->code != $request->code)
                return $this->apiResponse(404, ['data' => [], 'message' => [trans('api.IncorrectCode')]]);
            $code->delete();
            $user->update(['password' => Hash::make($request->password)]);
            return $this->apiResponse(200, ['data' => [], 'message' => [trans('api.passChange')]]);
        } else
            return $this->apiResponse(404, ['data' => [], 'message' => [trans('api.UserNotFound')]]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'mobile' => 'required|numeric|unique:users',
            'email' => 'email|unique:users|max:255|nullable',
            'gender' => 'required|string|max:255',
            'password' => 'required|string|max:255',
            'password_confirmation' => 'required_with:password|same:password'

        ]);
        if ($validator->fails()) {
            return $this->apiResponse(422, ['data' => [], 'message' => $validator->errors()->all()]);
        }
        $user = User::Create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => Hash::make($request->password),
        ]);
        $otp = rand(10000, 99999);
        if ( $user->OTP != null )
            $user->OTP->delete();
        $user->otp()->create(['code' => $otp]);
        $result = $this->sendOtp($otp, $request->mobile , $request->email , 'sms');

        if (  $request->has('token')  )
            $user->pushNotification()->create([
                'device' => $request->has('device') ? $request->device : 'unknown',
                'token' => $request->token,
            ]);

        if ($result)
            return $this->apiResponse(200, ['data' => [], 'message' => [trans('api.success')]]);
        else
            return $this->apiResponse(400, ['data' => [], 'message' => [trans('api.unknownError')]]);
    }

    public function registerationCodeValidation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required',
            'code' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->apiResponse(422, ['data' => [], 'message' => $validator->errors()->all()]);
        }
        $user = User::where('mobile', $request->mobile)->where('otp_verified' , 0)->first();
        if ( $user == null )
            return $this->apiResponse(422, ['data' => [], 'message' => [trans('api.incorrectMobile')]]);


        $userOtp = $user->OTP ;
        if (isset($userOtp) && $userOtp->code == $request->code) {
            $user->update(['otp_verified'=>1]);
            $userOtp->delete();
            $tokenResult = $user->createToken('freelancer Personal Access Token');
            $user = $user->toArray();
            unset($user['o_t_p']);
            return $this->apiResponse(200, ['data' => ['access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString(),
                'user' => $user], 'message' => [trans('api.success')]]);
        } else
            return $this->apiResponse(422, ['data' => [], 'message' => [trans('api.IncorrectCode')]]);
    }

    public function registerationResentCodeValidation(Request $request)
    {
        $user = User::where('mobile', $request->mobile)->where('otp_verified' , 0)->first();
        if ( $user == null )
            return $this->apiResponse(422, ['data' => [], 'message' => [trans('api.incorrectMobile')]]);

        $userOtp = $user->OTP ;
        if ($userOtp == null ) {
            $otp = rand(10000, 99999);
            $userOtp = $user->otp()->create(['code' => $otp]);
        }
        $result = $this->sendOtp($userOtp->code, $user->mobile , $user->email , 'sms');
        if ($result)
            return $this->apiResponse(200, ['data' => [], 'message' => [trans('api.success')]]);
        else
            return $this->apiResponse(400, ['data' => [], 'message' => [trans('api.unknownError')]]);
    }


    public function updateProfile(Request $request)
    {
        if ( $request->has('notification')){
            $resource = Auth::user();
            $resource->recive_notification = $request->notification;
            $resource->save();
            return $this->apiResponse(200, ['data' => [], 'message' => [trans('api.success')]]);
        }
        if ( $request->has('password')){
            $validator = Validator::make($request->all(), [
                'old_password' => 'required',
                'password' => 'required',
                'password_confirmation' => 'required_with:password|same:password'
            ]);
            if ($validator->fails()) {
                return $this->apiResponse(422, ['data' => [], 'message' => $validator->errors()->all()]);
            }
            $resource = Auth::user();
            $code = $resource->OTP ;
            if ($code == null  or $code->code != $request->code)
                return $this->apiResponse(404, ['data' => [], 'message' => [trans('api.incorrectMobile')]]);
            $code->delete();

            if ( ! Hash::check($request->old_password , $resource->password ))
                return $this->apiResponse(422, ['data' => [], 'message' => [trans('api.incorrectOldPassword')]]);

            $resource->update(['password' => Hash::make($request->password)]);
            $resource->save();
            return $this->apiResponse(200, ['data' => [], 'message' => [trans('api.success')]]);
        }
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required|string',
            'mobile' => 'required|string',
            'email' => 'required|string',
            'gender' => 'required|string',
        ]);
        if ($validator->fails()) {
            return $this->apiResponse(422, ['data' => [], 'message' => $validator->errors()->all()]);
        }

        $resource = Auth::user();
        $cover_image = $resource->image;
        if ($request->hasFile('image'))
            $cover_image = '/uploads/users/'.Common::editImage($request, 'image', $this->path, $this->image_big_w, $this->image_big_h, $this->image_thumb_w, $this->image_thumb_h, $resource);
        $resource->first_name = $request->first_name;
        $resource->last_name = $request->last_name;
        $resource->mobile = $request->mobile;
        $resource->email = $request->email;
        $resource->gender = $request->gender;
        $resource->birthday = $request->birthday;
        $resource->is_active = !empty($request->input('is_active')) ? '1' : '0';
        $resource->image = $cover_image;
        $resource->save();

        return $this->apiResponse(200, ['data' => ['user'=>$resource], 'message' => [trans('api.success')]]);

    }


}


