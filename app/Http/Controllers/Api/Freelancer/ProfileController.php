<?php

namespace App\Http\Controllers\Api\Freelancer;

use App\Freelancer;
use App\Http\Controllers\Admin\Common;
use App\Meeting;
use App\ServiceUserOrders;
use App\Settings;
use App\User;
use App\WorkshopOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function subscription(){
        $user = Auth::user();
        $package = $user->package()->first();
        return $this->apiResponse(200, ['data' => [
            'title' => $package->duration_title ,
            'cost' => $package->price ,
            'expiration' => $user->expiration_date ,
            'start' => date('Y-m-d', strtotime( '-'.$package->duration.' day', strtotime($user->expiration_date))),
        ], 'message' => []]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile(Request $request){
        $token = str_replace("Bearer " , "" , $request->header('Authorization'));
        $user = Freelancer::find(Auth::id());
        return $this->apiResponse(200, ['data' => [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::now()->toDateTimeString(),
            'subscribe_active' => Settings::where("keyname", "setting")->first()->subscribe_active_in_app,
            'user' => $user,
        ], 'message' => [trans('api.success')]]);

//        $user = Auth::user();
//        return $this->apiResponse(200, ['data' => $user, 'message' => []]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        if ( $request->has('password')){
            $this->validate($request, [
                'old_password' => 'required',
                'password' => 'required',
                'password_confirmation' => 'required_with:password|same:password'
            ]);
            $resource = Auth::user();
            $code = $resource->OTP ;
            if ($code == null  or $code->code != $request->code)
                return $this->apiResponse(404, ['data' => [], 'message' => [trans('api.IncorrectCode')]]);
            $code->delete();

            if ( ! Hash::check($request->old_password , $resource->password ))
                return $this->apiResponse(422, ['data' => [], 'message' => [trans('api.incorrectOldPassword')]]);

            $resource->update(['password' => Hash::make($request->password)]);
            $resource->save();
            return $this->apiResponse(200, ['data' => [], 'message' => []]);
        }
        if ( ! $request->hasAny(['quotation' , 'set_a_meeting', 'offline', 'location_type' , 'recive_notification']) ){
            $this->validate($request, [
                'birthday' => 'nullable|date',
                'email' => 'required|email|unique:freelancers,email,'.Auth::id(),
                'username' => 'nullable|string|unique:freelancers,username,'.Auth::id(),
            ]);
        }
        /* @var  \App\Freelancer $user */
        $user = Auth::user();

        if ( $request->hasAny('username') and $request->get('username' ) != $user->username ){
            if ( $user->username_changed_at != null and now()->subYear()->lt($user->username_changed_at) ){
                return $this->apiResponse(422, ['data' => [], 'message' => [trans('api.usernamePerYear')]]);
            }
            $request->merge([ 'username_changed_at' => now()]);
        } else {
            $request->merge([ 'username' => $user->username]);
        }
        if ($request->hasFile('file')) {
            $cover_image = Common::uploadImage($request, 'file', 'freelancer', 0, 0, 0, 0);
            $request->merge([
                'image' => '/uploads/freelancer/'.$cover_image
            ]);
        }
        $user->update($request->except(['file' , 'service_commission_price' ,'service_commission_percent','service_commission_type'
            , 'workshop_commission_price' ,'workshop_commission_percent','workshop_commission_type'
            , 'bill_commission_price' ,'bill_commission_percent','bill_commission_type']));
        if ( $request->has('offline') ){
            $message = collect();
            $serviceOrder = ServiceUserOrders::where('freelancer_id' , $user->id)->whereNotIn('status' , ['freelancer_cancel','user_cancel','user_not_available','freelancer_not_available','admin_cancel','completed'])->get();
            if (count($serviceOrder)>0)
            $message->push(trans('api.activeService'));

            $workshop = WorkshopOrder::query()->where('freelancer_id' , $user->id)->whereHas('workshop', function ($q){
                $q->where('date', '>=', Carbon::now()->toDateString());
            })->with('workshop')->get()->map(function ($item){
                return $item->workshop;
            });
            if (count($workshop)>0)
                $message->push(trans('api.activeWorkshops'));
            $meeting = Meeting::query()->where('freelancer_id' , $user->id)
                ->where('date', '>=', Carbon::now()->toDateString())->get();
            if (count($meeting)>0)
                $message->push(trans('api.activeMeetings'));

            return $this->apiResponse(200, ['data' => ['services'=>$serviceOrder, 'workshops'=>$workshop, 'meetings'=>$meeting], 'message' => $message]);

        }
        $token = str_replace("Bearer " , "" , $request->header('Authorization'));
        return $this->apiResponse(200, ['data' => [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::now()->toDateTimeString(),
            'subscribe_active' => Settings::where("keyname", "setting")->first()->subscribe_active_in_app,
            'user' => $user,
        ], 'message' => [trans('api.success')]]);
        //return $this->apiResponse(200, ['data' => [], 'message' => []]);
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
        $result = $this->sendOtp($userOtp->code, $user->phone,  $user->email, $request->type );

        if ($result != "ok") {
            return $this->apiResponse(422, ['data' => [], 'message' => [$result]]);
        } else
            return $this->apiResponse(200, ['data' => [], 'message' => []]);
    }

}
