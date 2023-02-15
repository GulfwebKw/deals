<?php

namespace App\Http\Controllers\Api\User;

use App\Category;
use App\Freelancer;
use App\FreelancerServices;
use App\FreelancerUserMessage;
use App\FreelancerWorkshop;
use App\Meeting;
use App\Settings;
use App\Slideshow;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class SearchController extends Controller
{

    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => ['required'],
            'data' => ['nullable'],
        ]);

        if ($validator->fails()) {
            return $this->apiResponse(422, ['data' => [], 'message' => $validator->errors()->all()]);
        }
//        config(['translatable.locale'  => request()->header('accept-language')]);
        config(['translatable.locale'  => 'en']);

        $settingInfo = Settings::where("keyname", "setting")->first();
        $pageNumber = $request->hasHeader('per-page') ? (int) $request->header('per-page') : $settingInfo->item_per_page_back ;

        $type = $request->type;
        $data = $request->data;
        if ($type == 'freelancer') {
            $freelancers = Freelancer::where('freelancers.name', 'like', '%' . $data . '%')
                ->where('freelancers.is_active' , 1 )
                ->where('freelancers.offline' , 0 )
                ->whereDate('freelancers.expiration_date' , '>=', \Illuminate\Support\Carbon::now())
                ->with('rate')
                ->rates($request->rate_filter)
                ->service($request->price_filter)->orderByDesc('id')->paginate($pageNumber);
            return $this->apiResponse(200, ['data' => [
                'freelancers' => $freelancers
            ], 'message' => []]);
        }

        if ($type == 'service') {
            $services = FreelancerServices::where('name', 'like', '%' . $data . '%')->whereHas('freelancer', function ($q) use ($request){
                $q->where('is_active' , 1 )
                    ->where('offline' , 0 )
                    ->whereDate('expiration_date' , '>=', \Illuminate\Support\Carbon::now())
                    ->rates($request->rate_filter);
            })->with('freelancer','freelancer.rate','category')
                ->when($request->price_filter , function ($query) use($request) {
                    $query->orderBy('price',$request->price_filter);
                })->orderByDesc('id')->paginate($pageNumber);
            return $this->apiResponse(200, ['data' => ['services' => $services], 'message' => []]);
        }

        if ($type == 'workshop') {
            $workshops = FreelancerWorkshop::whereHas('translations', function ($q) use($data){
                    $q->where('name', 'like', '%' . $data . '%');
            })->whereHas('freelancer', function ($q) use ($request){
                $q->where('is_active' , 1 )
                    ->where('offline' , 0 )
                    ->whereDate('expiration_date' , '>=', \Illuminate\Support\Carbon::now())
                    ->rates($request->rate_filter);
            })->where('is_active', 1)->with('freelancer','freelancer.rate')
                ->when($request->price_filter , function ($query) use($request) {
                    $query->orderBy('price',$request->price_filter);
                })->orderByDesc('id')->paginate($pageNumber)->toArray();
            $workshops = $this->deleteTranslations($workshops);
            return $this->apiResponse(200, ['data' => ['workshop' => $workshops], 'message' => []]);
        }

        if ($type == 'all') {
            $workshops = FreelancerWorkshop::whereHas('translations', function ($q) use($data){
                    $q->where('name', 'like', '%' . $data . '%');
            })->whereHas('freelancer', function ($q) use ($request){
                    $q->where('is_active' , 1 )
                        ->where('offline' , 0 )
                        ->whereDate('expiration_date' , '>=', \Illuminate\Support\Carbon::now())
                        ->rates($request->rate_filter);
                })->where('is_active', 1)->with('freelancer','freelancer.rate')
                ->when($request->price_filter , function ($query) use($request) {
                    $query->orderBy('price',$request->price_filter);
                })->orderByDesc('id')->paginate($pageNumber)->toArray();
            $workshops = $this->deleteTranslations($workshops);
            $services = FreelancerServices::where('name', 'like', '%' . $data . '%')->whereHas('freelancer', function ($q) use($request){
                    $q->where('is_active' , 1 )
                        ->where('offline' , 0 )
                        ->whereDate('expiration_date' , '>=', \Illuminate\Support\Carbon::now())
                        ->rates($request->rate_filter);
                })->with('freelancer','freelancer.rate','category')
                ->when($request->price_filter , function ($query) use($request) {
                    $query->orderBy('price',$request->price_filter);
                })->orderByDesc('id')->paginate($pageNumber);
            $freelancers = Freelancer::where('freelancers.name', 'like', '%' . $data . '%')
                ->where('freelancers.is_active' , 1 )
                ->where('freelancers.offline' , 0 )
                ->whereDate('freelancers.expiration_date' , '>=', \Illuminate\Support\Carbon::now())
                ->with('rate')
                ->rates($request->rate_filter)
                ->service($request->price_filter)->orderByDesc('id')->paginate($pageNumber);
            return $this->apiResponse(200, ['data' => ['workshop' => $workshops,'services' => $services,'freelancers' => $freelancers], 'message' => []]);
        }
        return $this->apiResponse(404, ['data' => [], 'message' => []]);
    }

    private function deleteTranslations($datas)
    {
        if ( is_array($datas['data'])){
            foreach ($datas['data'] as $index => $data){
                unset($datas['data'][$index]['translations']);
            }
        }
        return $datas;
    }

}
