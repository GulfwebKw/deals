<?php

namespace App\Http\Controllers\Api\Freelancer;



use App\Area;
use App\City;
use App\Country;
use App\Freelancer;
use App\FreelancerAddress;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class FreelancerAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $freelancer = Auth::user();
        $address = $freelancer->address()->orderByDesc('id')->with('area.city.country')->get();
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
            'full_name'=>'required',
            'block'=>'required',
            'street'=>'required',
            'avenue'=>'required',
            'house_apartment'=>'required',
            'floor'=>'required',
            'lat'=>'required',
            'lng'=>'required',
            'country_id'=>'required',
            'city_id'=>'required',
            'area_id'=>'required',
            'address'=>'required',
            'phone'=>'required',
            'mobile'=>'required',
        ]);
        if ($validator->fails()) {
            return $this->apiResponse(422, ['data' => [], 'message' => $validator->errors()->all()]);
        }

        $freelancer = Auth::user();
        $country = Country::findOrFail($request->country_id);
        $city = City::findOrFail($request->city_id);
        $area = Area::findOrFail($request->area_id);
        $request->merge([
            'freelancer_id' => Auth::id(),
            'country' => $country->title_en,
            'city' => $city->title_en,
            'area' => $area->title_en,
        ]);
        $newAddress = $freelancer->address()->create($request->all());
        return $this->apiResponse(200, ['data' => ['newAddress' => $newAddress ], 'message' => [trans('api.addressAdded')]]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($address_id)
    {
        $freelancer = Auth::user();
        $address = FreelancerAddress::with('area.city.country')->findOrFail($address_id);
        if ( $address->freelancer_id != $freelancer->id )
            return $this->apiResponse(403, ['data' => [], 'message' => [trans('api.notAccess')]]);
        return $this->apiResponse(200, ['data' => ['address' => $address ], 'message' => []]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $address_id)
    {
        $validator = Validator::make($request->all(), [
            'full_name'=>'required',
            'block'=>'required',
            'street'=>'required',
            'avenue'=>'required',
            'house_apartment'=>'required',
            'floor'=>'required',
            'lat'=>'required',
            'lng'=>'required',
            'country_id'=>'required',
            'city_id'=>'required',
            'area_id'=>'required',
            'address'=>'required',
            'phone'=>'required',
            'mobile'=>'required',
        ]);
        if ($validator->fails()) {
            return $this->apiResponse(422, ['data' => [], 'message' => $validator->errors()->all()]);
        }

        $freelancer = Auth::user();
        $address = FreelancerAddress::findOrFail($address_id);
        if ( $address->freelancer_id != $freelancer->id )
            return $this->apiResponse(403, ['data' => [], 'message' => [trans('api.notAccess')]]);
        $country = Country::findOrFail($request->country_id);
        $city = City::findOrFail($request->city_id);
        $area = Area::findOrFail($request->area_id);
        $request->merge([
            'freelancer_id' => $freelancer->id,
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
    public function destroy($address_id)
    {
        $freelancer = Auth::user();
        $address = FreelancerAddress::findOrFail($address_id);
        if ( $address->freelancer_id != $freelancer->id )
            return $this->apiResponse(403, ['data' => [], 'message' => [trans('api.notAccess')]]);
        $address->delete();
        return $this->apiResponse(200, ['data' => [], 'message' => [trans('api.addressDeleted')]]);
    }
}
