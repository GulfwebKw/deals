<?php

namespace App\Http\Controllers\Api\User;

use App\Freelancer;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BookmarkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $user = Auth::user();
        $wishlists = $user->wishlist()
            ->whereDate('expiration_date' , '>=', \Illuminate\Support\Carbon::now())
            ->where('is_active' , 1 )
            ->with('rate')->get();
        return $this->apiResponse(200, ['data' => ['wishlists' => $wishlists], 'message' => [trans('api.success')]]);
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
            'freelancer_id' => ['required' , 'integer' , 'exists:freelancers,id'],
        ]);
        if ($validator->fails()) {
            return $this->apiResponse(422, ['data' => [], 'message' => $validator->errors()->all()]);
        }
        $user = Auth::user();
        $user->wishlist()->syncWithoutDetaching($request->freelancer_id);
        return $this->apiResponse(200, ['data' => [], 'message' => [trans('api.freelancerAddToBookmark')]]);
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
        return $this->apiResponse(200, ['data' => ['highlight'=>$data], 'message' => [trans('api.freelancerAddOrRemoveToBookmark')]]);
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
        return $this->apiResponse(200, ['data' => [], 'message' => [trans('api.freelancerRemoveToBookmark')]]);
    }

}
