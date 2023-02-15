<?php

namespace App\Http\Controllers\Api\User;

use App\Freelancer;
use App\Http\Controllers\Admin\Common;
use App\Quotation;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserQuotationController extends Controller
{


    public $image_big_w = 0;
    public $image_big_h = 0;
    public $image_thumb_w = 128;
    public $image_thumb_h = 128;

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'freelancer_id' => ['required' , 'numeric' ,'exists:freelancers,id'],
            'description' => ['required' , 'string'],
            'budget' => ['required' , 'numeric'],
            'place' => [ 'nullable', 'string' ,'max:190'],
            'date' => 'nullable|date|after_or_equal:today',
            'time' => 'nullable',
            'payment_type' => ['required' , 'in:Full payment,Installment'],
        ]);
        if ($validator->fails()) {
            return $this->apiResponse(422, ['data' => [], 'message' => $validator->errors()->all()]);
        }
        $freelancer = Freelancer::findOrFail($request->freelancer_id);
        if (!$freelancer->is_active or $freelancer->offline) {
            return $this->apiResponse(404, ['data' => [], 'message' => [trans('api.FreelancerDeactivate')]]);
        }
        if (!$freelancer->set_a_meeting) {
            return $this->apiResponse(404, ['data' => [], 'message' => [trans('api.deactivateQuotation')]]);
        }
        $cover_image = Common::uploadImage($request, 'attachment', 'quotation' , $this->image_big_w, $this->image_big_h, $this->image_thumb_w, $this->image_thumb_h);

        $user = Auth::user();
        $request->merge(['attachment' => '/uploads/quotation/'.$cover_image]);
        $quotations = $user->quotations()->create([
            'freelancer_id'=>$request->freelancer_id,
            'description'=>$request->description,
            'budget'=>$request->budget,
            'place'=>$request->place,
            'time'=>$request->time,
            'date'=>$request->date,
            'attachment'=> '/uploads/quotation/'. $cover_image,
        ]);


        $messageBody = sprintf("New quotation receive.\nBudget: %s\nPlace: %s\nDate & Time: %s %s\nQuantity: %s\Description: %s",
            number_format($request->budget) ,
            $request->place,
            Carbon::parse($request->date)->format('Y M d'),
            Carbon::parse($request->time)->format('H:i'),
            $request->quantity ?? "1",
            $request->description
        );
        $user->messages()->create([
            'type' => 'user',
            'status' => '0',
            'freelancer_id' => $request->freelancer_id,
            'message' => $messageBody ,
            'message_type' => '6',
            'lat' => "",
            'long' => "",
            'file' => null,
            'userRead' => 1,
            'freelancerRead' => 0,
        ]);



        return $this->apiResponse(200, ['data' => ['quotation' => $quotations], 'message' => [trans('api.sendQuotation')]]);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $userQuotation = Quotation::where('user_id', Auth::id())->with('freelancer' , 'services' ,'installments','freelancerAddress.area.city.country')->findOrFail($id);
            return $this->apiResponse(200, ['data' => ['quotation' => $userQuotation], 'message' => ['success']]);
        } catch(ModelNotFoundException $exception)  {
            return $this->apiResponse(404, ['data' => [ 'model' =>$exception->getModel() , 'ids' => $exception->getIds() ], 'message' => [$exception->getMessage()]]);
        } catch ( \Exception $exception){
            return $this->apiResponse(500, ['data' => [ 'error' => $exception->getMessage()], 'message' => ['can not set meeting now!']]);
        }
    }

}
