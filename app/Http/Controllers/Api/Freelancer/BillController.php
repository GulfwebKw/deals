<?php

namespace App\Http\Controllers\Api\Freelancer;

use App\Http\Controllers\Common;
use App\UserNotification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $user = Auth::user();
        $bills = $user->bills()->orderByDesc('id')->get();
        return $this->apiResponse(200, ['data' => ['bills' => $bills], 'message' => []]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'user_id'=>'required|numeric|exists:users,id',
            'user_name'=>'required',
            'amount'=>'required|numeric|min:0',
            'description'=>'required',
            'expire_at'=>'required|date',
        ]);
        $user = Auth::user();
        
        switch ($user->bill_commission_type) {
            case 'price':
                if ($request->amount - $user->bill_commission_price > 0) {
                    $earn = $request->amount - $user->bill_commission_price;
                    $commission = $user->bill_commission_price;
                } else {
                    $earn = 0;
                    $commission = $request->amount;
                }
                break;
            case 'percent':
                $earn = round($request->amount * (100 - $user->bill_commission_percent) / 100);
                $commission = $request->amount - $earn;
                break;
            case 'plus':
                $earnTemp = round($request->amount * (100 - $user->bill_commission_percent) / 100) - $user->bill_commission_price;
                $earn = ($earnTemp > 0) ? $earnTemp : 0;
                $commission = ($earnTemp > 0) ? $request->amount - $earnTemp : $request->amount;
                break;
            case 'min':
                $earnTempPercent = round($request->amount * (100 - $user->bill_commission_percent) / 100);
                $earnTempPrice = ($request->amount - $user->bill_commission_price > 0) ? $request->amount - $user->bill_commission_price : 0;
                $earn = max($earnTempPercent, $earnTempPrice);
                $commission = $request->amount - $earn;
                break;
            case 'max':
                $earnTempPercent = round($request->amount * (100 - $user->bill_commission_percent) / 100);
                $earnTempPrice = ($request->amount - $user->bill_commission_price > 0) ? $request->amount - $user->bill_commission_price : 0;
                $earn = min($earnTempPercent, $earnTempPrice);
                $commission = $request->amount - $earn;
                break;
            default :
                $earn = $request->amount;
                $commission = 0;
                break;
        }
            
        $request->merge([
            'earn' => $earn,
            'commission' => $commission,
            'uuid' => \Illuminate\Support\Str::uuid(),
            'order_track' => substr(time(), 5, 4) . rand(1000, 9999)
        ]);

        $bill = $user->bills()->create($request->all());
        
        
        $user->messages()->create([
            'type' => 'freelancer',
            'status' => '0',
            'user_id' => $request->user_id,
            'message' => $bill->uuid ,
            'message_type' => '7' ,
            'file' => null,
            'userRead' => 0,
            'freelancerRead' => 1,
        ]);

        UserNotification::add($request->user_id, $user->id, ['newBill', $request->description, number_format($request->amount) , $request->expire_at], 'newBill', ['bill_uuid' => $bill->uuid , 'bill_id' => $bill->id]);

        return $this->apiResponse(200, ['data' => ['bill' => $bill ], 'message' => [trans('api.billMade')]]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $user = Auth::user();
        $bill = $user->bills()->findOrFail($id);
        return $this->apiResponse(200, ['data' => ['bill' => $bill], 'message' => []]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
         $this->validate($request, [
            'user_id'=>'required|numeric|exists:users,id',
            'user_name'=>'required',
            'amount'=>'required|numeric|min:0',
            'description'=>'required',
            'expire_at'=>'required|date',
        ]);
        $user = Auth::user();
        $bill = $user->bills()->where('payment_status' , 'waiting')->findOrFail($id);
        
        switch ($user->bill_commission_type) {
            case 'price':
                if ($request->amount - $user->bill_commission_price > 0) {
                    $earn = $request->amount - $user->bill_commission_price;
                    $commission = $user->bill_commission_price;
                } else {
                    $earn = 0;
                    $commission = $request->amount;
                }
                break;
            case 'percent':
                $earn = round($request->amount * (100 - $user->bill_commission_percent) / 100);
                $commission = $request->amount - $earn;
                break;
            case 'plus':
                $earnTemp = round($request->amount * (100 - $user->bill_commission_percent) / 100) - $user->bill_commission_price;
                $earn = ($earnTemp > 0) ? $earnTemp : 0;
                $commission = ($earnTemp > 0) ? $request->amount - $earnTemp : $request->amount;
                break;
            case 'min':
                $earnTempPercent = round($request->amount * (100 - $user->bill_commission_percent) / 100);
                $earnTempPrice = ($request->amount - $user->bill_commission_price > 0) ? $request->amount - $user->bill_commission_price : 0;
                $earn = max($earnTempPercent, $earnTempPrice);
                $commission = $request->amount - $earn;
                break;
            case 'max':
                $earnTempPercent = round($request->amount * (100 - $user->bill_commission_percent) / 100);
                $earnTempPrice = ($request->amount - $user->bill_commission_price > 0) ? $request->amount - $user->bill_commission_price : 0;
                $earn = min($earnTempPercent, $earnTempPrice);
                $commission = $request->amount - $earn;
                break;
            default :
                $earn = $request->amount;
                $commission = 0;
                break;
        }
            
        $request->merge([
            'earn' => $earn,
            'commission' => $commission,
        ]);
        
        $bill->update($request->all());
        return $this->apiResponse(200, ['data' => ['bill' => $bill ], 'message' => [trans('api.billUpdate')]]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $user->bills()->where('payment_status' , 'waiting')->findOrFail($id)->delete();
        return $this->apiResponse(200, ['data' => [], 'message' => [trans('api.billDeleted')]]);
    }

}
