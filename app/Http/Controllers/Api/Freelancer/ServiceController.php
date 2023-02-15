<?php

namespace App\Http\Controllers\Api\Freelancer;

use App\Freelancer;
use App\ServiceUserOrders;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Admin\Common;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $services = $user->services()->when($request->category_id != null , function ($query) use($request){ $query->where('category_id' , $request->category_id);})->orderByDesc('id')->get();
        return $this->apiResponse(200, ['data' => ['services' => $services], 'message' => []]);
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
            'name'=>'required',
            'price'=>'required',
            'short_desc'=>'required',
            'category_id'=>'required|exists:categories,id',
        ]);
        if ($validator->fails()) {
            return $this->apiResponse(422, ['data' => [], 'message' => $validator->errors()->all()]);
        }

        $user = Auth::user();
        if ($request->hasFile('file')) {
            $cover_image = Common::uploadImage($request, 'file', 'services', 0, 0, 0, 0);
            $request->merge([
                'images' => '/uploads/services/'.$cover_image,
                'image' => '/uploads/services/'.$cover_image
            ]);
        }
        $newServices = $user->services()->create($request->except('file'));
        return $this->apiResponse(200, ['data' => ['newServices' => $newServices ], 'message' => []]);
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
        $service = $user->services()->findOrFail($id);
        return $this->apiResponse(200, ['data' => ['service' => $service ], 'message' => []]);
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
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'price'=>'required',
            'short_desc'=>'required',
        ]);
        if ($validator->fails()) {
            return $this->apiResponse(422, ['data' => [], 'message' => $validator->errors()->all()]);
        }

        $user = Auth::user();
        $service = $user->services()->findOrFail($id);
        if ( ServiceUserOrders::where('service_id' , $service->id)->whereNotIn('status' , ['freelancer_cancel','user_cancel','user_not_available','freelancer_not_available','admin_cancel','completed'])->exists() ){
            return $this->apiResponse(401, ['data' => [], 'message' => [trans('api.hasOrder')]]);
        }
        if ($request->hasFile('file')) {
            $cover_image = Common::uploadImage($request, 'file', 'services', 0, 0, 0, 0);
            $request->merge([
                'images' => '/uploads/services/'.$cover_image,
                'image' => '/uploads/services/'.$cover_image
            ]);
        }
        $service->update($request->except('file'));
        return $this->apiResponse(200, ['data' => ['service' => $service ], 'message' => []]);
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
        $service = $user->services()->findOrFail($id);
        if ( ServiceUserOrders::where('service_id' , $service->id)->whereNotIn('status' , ['freelancer_cancel','user_cancel','user_not_available','freelancer_not_available','admin_cancel','completed'])->exists() ){
            return $this->apiResponse(401, ['data' => [], 'message' => [trans('api.hasOrder')]]);
        }
        $service->delete();
        return $this->apiResponse(200, ['data' => [], 'message' => []]);
    }
}
