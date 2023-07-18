<?php

namespace App\Http\Controllers\Api\Freelancer;

use App\Http\Controllers\Admin\webPushController;
use App\Http\Controllers\Common;
use App\PushDevices;
use App\Settings;
use App\WebPushMessage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class WorkshopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $user = Auth::user();
        $workshop = $user->workshops()->with('area.city.country')->orderByDesc('id')->get()->toArray();
        $workshop = $this->deleteTranslations($workshop);
        return $this->apiResponse(200, ['data' => ['workshop' => $workshop], 'message' => []]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $this->validate($request, [
            'name'=>'required',
            'date'=>'required|date|after_or_equal:today|before:'. ( $user->expiration_date ?? "1990-01-01" ),
            'from_time'=>'required',
            'to_time'=>'nullable',
            'street'=>'required',
            'block'=>'required',
            'building_name'=>'required',
            'area_id'=>'required|numeric|exists:gwc_areas,id',
            'price'=>'required|numeric',
            'total_persons'=>'required|numeric',
        ]);
        if ($request->hasFile('file')) {
            $cover_image = Common::uploadImage($request, 'file', 'workshop', 0, 0, 0, 0);
            $request->merge([
                'images' => '/uploads/workshop/'.$cover_image
            ]);
        }
        $request->merge([
            'available' => $request->total_persons,
        ]);

        $workshops = $user->workshops()->create($request->except('file'));

        $OTPTokens = PushDevices::where('device' , 'admin')->get()->pluck('token')->unique();
        $WebPushs = new WebPushMessage;
        $WebPushs->title = 'Deals';
        $WebPushs->message = 'New workshop pending for approve.';
        $WebPushs->action_url = asset('gwc/workshops/approval');
        webPushController::sendWebPushy($OTPTokens, $WebPushs );
        return $this->apiResponse(200, ['data' => ['workshop' => $workshops ], 'message' => []]);
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
        $workshop = $user->workshops()->with('area.city.country')->findOrFail($id)->toArray();
        $workshop = $this->deleteTranslations([$workshop])[0];
        return $this->apiResponse(200, ['data' => ['workshop' => $workshop], 'message' => []]);
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
            'name'=>'required',
            'date'=>'required|date',
            'from_time'=>'required',
            'to_time'=>'nullable',
            'street'=>'required',
            'block'=>'required',
            'building_name'=>'required',
            'area_id'=>'required|numeric|exists:gwc_areas,id',
            'price'=>'required|numeric',
            'total_persons'=>'required|numeric',
        ]);
        $user = Auth::user();
        $workshop = $user->workshops()->findOrFail($id);
        if ($request->hasFile('file')) {
            $cover_image = Common::uploadImage($request, 'file', 'workshop', 0, 0, 0, 0);
            $request->merge([
                'images' => '/uploads/workshop/'.$cover_image
            ]);
        }
        $request->merge([
            'available' => $request->total_persons - $workshop->reserved,
        ]);
        $workshops = $workshop->update($request->except('file'));
        return $this->apiResponse(200, ['data' => ['workshop' => $workshops ], 'message' => []]);
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
        $workshop = $user->workshops()->findOrFail($id);
        if ( $workshop->reserved == 0 ) {
            $workshop->delete();
            return $this->apiResponse(200, ['data' => [], 'message' => [trans('api.freelancer.cancellation.workshop')]]);
        } else {
            return $this->apiResponse(400, ['data' => [], 'message' => [trans('api.freelancer.cancellation.workshopBooked')]]);
        }
    }




    private function deleteTranslations($datas)
    {
        if ( is_array($datas)){
            foreach ($datas as $index => $data){
                if ( isset($data['children_recursive']) and is_array($data['children_recursive']) and count($data['children_recursive']) > 0)
                    $datas[$index]['children_recursive'] = $this->deleteTranslations($data['children_recursive']);
                unset($datas[$index]['translations']);
            }
        }
        return $datas;
    }
}
