<?php

namespace App\Http\Controllers\Api\User;

use App\ServiceUserOrders;
use App\User;
use App\UserOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FreelancerRateController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request , $id)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => ['required' , 'numeric' ,'exists:user_orders,id'],
            'service_id' => ['required' , 'numeric' ,'exists:freelancer_services,id'],
            'rate' => ['required' , 'numeric' ,'min:0' , 'max:5']
        ]);
        if ($validator->fails()) {
            return $this->apiResponse(422, ['data' => [], 'message' => $validator->errors()->all()]);
        }
        $user = Auth::user();
        $order = UserOrder::findOrFail($request->order_id);
        if ( $order->user_id != $user->id )
            return $this->apiResponse(403, ['data' => [], 'message' => [trans('api.notAccess')]]);

        $service = ServiceUserOrders::where('order_id' , $order->id )
            ->where('service_id' , $request->service_id )
            ->whereNull('rate' )->with(['service.freelancer'])->first();

        if ( $service == null)
            return $this->apiResponse(409 , ['data' => [], 'message' => [trans('api.hasRate')]]);

        if ( isset($service['service']['freelancer'])  and $service['service']['freelancer']->id != $id  )
            return $this->apiResponse(403, ['data' => [], 'message' => [trans('api.notAccess')]]);

        $rate = \App\Rate::findOrFail($service['service']['freelancer']->rate_id);
        if ( $rate->number_people == -1 )
            $rate->number_people = 0 ;
        $rate->rate =  round( ( ( ( $rate->rate * $rate->number_people ) + $request->rate ) / ($rate->number_people  + 1 ) ) , 2 );
        $rate->number_people = $rate->number_people + 1 ;
        $rate->update();
        $service->rate =  $request->rate  ;
        $service->update();
        return $this->apiResponse(200, ['data' => [], 'message' => [trans('api.sendRate')]]);
    }
}
