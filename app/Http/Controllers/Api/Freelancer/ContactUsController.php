<?php

namespace App\Http\Controllers\Api\Freelancer;

use App\Settings;
use App\Freelancer;
use App\Message;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ContactUsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
      public function getSetting()
    {
        $setting = Settings::query()->first([
            'phone', 'mobile', 'email', 'fax', 
                'social_google_plus', 'social_facebook', 'social_instagram',
                'social_twitter', 'social_linkedin'
            ]);
        return $this->apiResponse(200, ['data' => ['setting'=>$setting], 'message' => []]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'mobile' => 'required',
            'subject' => 'required',
            'message' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->apiResponse(422, ['data' => [], 'message' => $validator->errors()->all()]);
        }
        $user = Auth::user();
        Message::create([
            'first_name' =>$request->first_name,
            'last_name' =>$request->last_name,
            'email' =>$request->email,
            'mobile' =>$request->mobile,
            'subject' =>$request->subject,
            'message' =>$request->message,
        ]);
       return  $this->apiResponse(200, ['data' => [], 'message' => [trans('api.messageSend')]]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request , $id)
    {
        $validator = Validator::make(['freelancer_id' => $id], [
            'freelancer_id' => ['required' , 'integer' , 'exists:freelancers,id'],
        ]);
        if ($validator->fails()) {
            return $this->apiResponse(422, ['data' => [], 'message' => $validator->errors()->all()]);
        }
        $user = Auth::user();
       $data =  $user->wishlist()->toggle($id);
        return $this->apiResponse(200, ['data' => ['highlight'=>$data], 'message' => ['success']]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $validator = Validator::make(['freelancer_id' => $id], [
            'freelancer_id' => ['required' , 'integer' , 'exists:freelancers,id'],
        ]);
        if ($validator->fails()) {
            return $this->apiResponse(422, ['data' => [], 'message' => $validator->errors()->all()]);
        }
        $user = Auth::user();
        $user->wishlist()->detach($id);
        return $this->apiResponse(200, ['data' => [], 'message' => ['success']]);
    }

}
