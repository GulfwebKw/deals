<?php

namespace App\Http\Controllers\Api\User;

use App\Category;
use App\Freelancer;
use App\FreelancerUserMessage;
use App\FreelancerWorkshop;
use App\Settings;
use App\Slideshow;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Carbon;

class WorkshopController extends Controller
{
    public function getWorkShops(Request $request)
    {
        $settings = Settings::where("keyname", "setting")->first();
        $pageNumber = $request->hasHeader('per-page') ? (int) $request->header('per-page') : $settings->item_per_page_back ;
//        config(['translatable.locale'  => request()->header('accept-language')]);
        config(['translatable.locale'  => 'en']);
        $resources = FreelancerWorkshop::with('freelancer' , 'area.city.country')->where('is_active' , 1 )->where('is_delete' , false)->whereHas('freelancer' , function($query) {
            $query->where('is_active' , 1 )
                ->where('offline' , 0 )
                ->whereDate('expiration_date' , '>=', \Illuminate\Support\Carbon::now());
        }  )->orderByDesc('id')->paginate($pageNumber)->toArray();
        $resources['data'] = $this->deleteTranslations($resources['data']);
        return $this->apiResponse(200, ['data' => ['workshops' => $resources], 'message' => []]);
    }
    
    public function getHighlightWorkShops(Request $request)
    {
        $settings = Settings::where("keyname", "setting")->first();
        $pageNumber = $request->hasHeader('per-page') ? (int) $request->header('per-page') : $settings->item_per_page_back ;
//        config(['translatable.locale'  => request()->header('accept-language')]);
        config(['translatable.locale'  => 'en']);
        $resources = FreelancerWorkshop::with('freelancer' , 'area.city.country')->where('is_delete' , false)->where('is_active' , 1 )->where('available' , '>' , 0 )->where('date', '>=', Date('Y-m-d'))->whereHas('freelancer' , function($query) {
            $query->where('is_active' , 1 )->where('offline' , 0 );
        }  )->orderByDesc('id')->paginate($pageNumber)->toArray();
        $resources['data'] = $this->deleteTranslations($resources['data']);
        return $this->apiResponse(200, ['data' => ['workshops' => $resources], 'message' => []]);
    }

    public function getSingleWorkShop(Request $request)
    {
//        config(['translatable.locale'  => request()->header('accept-language')]);
        config(['translatable.locale'  => 'en']);
        $resources = FreelancerWorkshop::with('freelancer', 'area.city.country')->find($request->id)->toArray();
        $resources = $this->deleteTranslations(array($resources));
        return $this->apiResponse(200, ['data' => ['workshop' => $resources[0]], 'message' => []]);
    }



    private function deleteTranslations($datas){
        if ( is_array($datas)){
            foreach ($datas as $index => $data){
                if ( isset($datas[$index]['translations']))
                    unset($datas[$index]['translations']);
                $datas[$index]['description'] = strip_tags($datas[$index]['description']);
            }
        }
        return $datas;
    }

}
