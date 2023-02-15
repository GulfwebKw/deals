<?php

namespace App\Http\Controllers\Api\Freelancer;

use App\Area;
use App\City;
use App\Country;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $user = Auth::user();
        $address = $user->address()->with('area.city.country')->where('disposable' , 0 )->orderByDesc('id')->get();
        return $this->apiResponse(200, ['data' => ['address' => $address], 'message' => []]);
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
//            'full_name'=>'required',
//            'block'=>'required',
//            'street'=>'required',
//            'avenue'=>'required',
//            'house_apartment'=>'required',
//            'floor'=>'required',
//            'lat'=>'required',
//            'lng'=>'required',
//            'country_id'=>'required',
//            'city_id'=>'required',
//            'area_id'=>'required',
//            'address'=>'required',
//            'phone'=>'required',
//            'mobile'=>'required',

            'country_id'=>'required',
            'city_id'=>'required',
            'area_id'=>'required',
        ]);
        if ($validator->fails()) {
            return $this->apiResponse(422, ['data' => [], 'message' => $validator->errors()->all()]);
        }

        $user = Auth::user();
        $country = Country::findOrFail($request->country_id);
        $city = City::findOrFail($request->city_id);
        $area = Area::findOrFail($request->area_id);
        $request->merge([
            'country' => $country->title_en,
            'city' => $city->title_en,
            'area' => $area->title_en,
        ]);
        $newAddress = $user->address()->create($request->all());
        return $this->apiResponse(200, ['data' => ['newAddress' => $newAddress ], 'message' => [trans('api.addressAdded')]]);
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
        $address = $user->address()->with('area.city.country')->findOrFail($id);
        return $this->apiResponse(200, ['data' => ['address' => $address ], 'message' => []]);

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
//            'full_name'=>'required',
//            'block'=>'required',
//            'street'=>'required',
//            'avenue'=>'required',
//            'house_apartment'=>'required',
//            'floor'=>'required',
//            'lat'=>'required',
//            'lng'=>'required',
//            'country_id'=>'required',
//            'city_id'=>'required',
//            'area_id'=>'required',
//            'address'=>'required',
//            'phone'=>'required',
//            'mobile'=>'required',

            'country_id'=>'required',
            'city_id'=>'required',
            'area_id'=>'required',
        ]);
        if ($validator->fails()) {
            return $this->apiResponse(422, ['data' => [], 'message' => $validator->errors()->all()]);
        }

        $user = Auth::user();
        $address = $user->address()->findOrFail($id);
        $country = Country::findOrFail($request->country_id);
        $city = City::findOrFail($request->city_id);
        $area = Area::findOrFail($request->area_id);
        $request->merge([
            'country' => $country->title_en,
            'city' => $city->title_en,
            'area' => $area->title_en,
        ]);
        $address->update($request->all());
        return $this->apiResponse(200, ['data' => ['address' => $address ], 'message' => [trans('api.addressUpdated')]]);
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
        $address = $user->address()->findOrFail($id);
        $address->delete();
        return $this->apiResponse(200, ['data' => [], 'message' => [trans('api.addressDeleted')]]);
    }


    public function areas(Request $request){
        $this->validate($request, [
            "area_id" => "required|array",
            'area_id.*'=>'required|numeric|exists:gwc_areas,id',
        ]);
        $user = Auth::user();
        $user->areas()->sync($request->area_id);
        return $this->apiResponse(200, ['data' => [], 'message' => [trans('api.areaAdded')]]);

    }
    public function getAreas(){
        $user = Auth::user();
        $areas = $user->areas()->where('is_active' , 1 )->with(['city' => function($query){
            $query->where('is_active' , 1 )->with(['country' => function($query2){
                $query2->where('is_active' , 1 );
            }]);
        }])->get();
        return $this->apiResponse(200, ['data' => ['areas' => $areas], 'message' => []]);
    }
}
