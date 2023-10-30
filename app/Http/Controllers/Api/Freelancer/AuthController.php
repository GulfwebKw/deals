<?php

namespace App\Http\Controllers\Api\Freelancer;

use App\Freelancer;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required|string',
        ]);
        if ($validator->fails()){
            return $this->apiResponse(422,['data'=>[], 'message'=>$validator->errors()->all()]);
        }

        $variable = 'phone';
        if(filter_var($request->email, FILTER_VALIDATE_EMAIL))
            $variable = 'email';

        if(!auth('freelancer')->attempt([$variable => $request->email, 'password' => $request->password], $request->remember))
            return $this->apiResponse(403,['data'=>[], 'message'=>[trans('api.incorrectLogin')]]);

        $user =  Auth::guard('freelancer')->user();
        if ($user->is_approved != "approved") {
            $user->pushNotification()->delete();
            $user->AauthAcessToken()->delete();
            return response()->json([
                'status' => 403,
                'data' => [],
                'message' => [trans('api.freelancer.' . ( $user->is_approved == "pending" ? "pending" : "reject") )]
            ], 401);
        }
        if (  \Illuminate\Support\Carbon::now()->gte($user->expiration_date) ) {
            $user->pushNotification()->delete();
            $user->AauthAcessToken()->delete();
            return response()->json([
                'status' => 204,
                'data' => [],
                'message' => [trans('api.PackageExpired')]
            ], 401);
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
        $freelancer = Freelancer::with('address')->find(Auth::id());
        return $this->apiResponse(200,['data'=>['profile' => $freelancer], 'message'=>[]]);
    }

    private function checkEmail($email) {
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
        return $this->apiResponse(200,['data'=>[], 'message'=>[trans('api.LogoutSuccessfully')]]);
    }


    public function sendForgotPasswordOTP(Request $request){
        $validator = Validator::make($request->all(), [
            'email_mobile' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->apiResponse(422, ['data' => [], 'message' => $validator->errors()->all()]);
        }
        $Freelancer = Freelancer::where('phone', $request->email_mobile)->orWhere('email', $request->email_mobile)->first();
        if (!isset($Freelancer)) {
            return $this->apiResponse(404, ['data' => [], 'message' => [trans('api.UserNotExist')]]);
        }
        $userOtp = $Freelancer->OTP ;
        if ($userOtp == null ) {
            $otp = rand(10000, 99999);
            $userOtp = $Freelancer->otp()->create(['code' => $otp]);
        }
        $result = $this->sendOtp($userOtp->code, $Freelancer->phone,  $Freelancer->email, 'email' );
        if ($result != "ok") {
            return $this->apiResponse(422, ['data' => [], 'message' => [$result]]);
        } else
            return $this->apiResponse(200, ['data' => [], 'message' => []]);
    }

    public function changeForgotPassword(Request $request)
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
        $Freelancer = Freelancer::query()->where('email', $request->email_mobile)->orWhere('phone', $request->email_mobile)->first();
        $code = $Freelancer->OTP ;
        if (isset($Freelancer) && $code != null) {
            if (isset($code->code) && $code->code != $request->code)
                return $this->apiResponse(404, ['data' => [], 'message' => [trans('api.IncorrectCode')]]);
            $code->delete();
            $Freelancer->update(['password' => Hash::make($request->password)]);
            return $this->apiResponse(200, ['data' => [], 'message' => [trans('api.passChange')]]);
        } else
            return $this->apiResponse(404, ['data' => [], 'message' => [trans('api.UserNotExist')]]);
    }

}
