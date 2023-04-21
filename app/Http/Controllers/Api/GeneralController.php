<?php

namespace App\Http\Controllers\Api;

use App\Country;
use App\Faq;
use App\Freelancer;
use App\Singlepage;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class GeneralController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function countries()
    {
        $lang = request()->header('accept-language');
        $areas = Country::where('is_active' , 1)->with(['cities' => function($query) use($lang) {
            $query->where('is_active' , 1)->with(['areas' => function($query2) use($lang) {
                $query2->where('is_active' , 1)->select('id','city_id','lat','lng','title_'.$lang.' as title');
            }])->select('id','country_id','lat','lng','title_'.$lang.' as title');
        }])->select('id','image','title_'.$lang.' as title')->get();
        return $this->apiResponse(200, ['data' => ['countries' => $areas], 'message' => []]);
    }


    public function termsConditions()
    {
        $lang = request()->header('accept-language');
        $resources = Singlepage::query()->where('name', 'TermsConditions')->get()->map(function ($q) use ($lang){
            return   array(
                'title'=>$q['title_'.$lang],
                'details'=>$q['details_'.$lang],
            );

        });
        return $this->apiResponse(200, ['data' => ['resources' => $resources[0]], 'message' => []]);
    }

    public function refundPolicy()
    {
        $lang = request()->header('accept-language');
        $resources = Singlepage::where('name', 'RefundPolicy')->first()->toArray();
        $resources['title'] = $resources['title_'.$lang];
        $resources['details'] = $resources['details_'.$lang];
        unset($resources['title_ar'] , $resources['details_ar'],$resources['title_en'] , $resources['details_en']);
        return $this->apiResponse(200, ['data' => ['resources' => $resources], 'message' => []]);
    }

    public function privacyPolicy()
    {
        $lang = request()->header('accept-language');
        $resources = Singlepage::where('name', 'PrivacyPolicy')->first()->toArray();
        $resources['title'] = $resources['title_'.$lang];
        $resources['details'] = $resources['details_'.$lang];
        unset($resources['title_ar'] , $resources['details_ar'],$resources['title_en'] , $resources['details_en']);
        return $this->apiResponse(200, ['data' => ['resources' => $resources], 'message' => []]);
    }

    public function LoginHelp()
    {
        $lang = request()->header('accept-language');
        $resources = Singlepage::where('name', 'LoginHelp')->first()->toArray();
        $resources['title'] = $resources['title_'.$lang];
        $resources['details'] = $resources['details_'.$lang];
        unset($resources['title_ar'] , $resources['details_ar'],$resources['title_en'] , $resources['details_en']);
        return $this->apiResponse(200, ['data' => ['resources' => $resources], 'message' => []]);
    }

    public function faq()
    {
        $lang = request()->header('accept-language');
        $resources = Faq::where('is_active', 1)
            ->orderBy('display_order')
            ->when(Auth::check() , function($query) {
                if ( Auth::user() instanceof Freelancer )
                    $query->where('active_for' , '!=' , 'User');
                if ( Auth::user() instanceof User )
                    $query->where('active_for' , '!=' , 'Freelancer');
            })->get()->map(function ($q) use ($lang){
                return[
                    'question'=> $q['question_'.$lang],
                    'answer'=>  $q['answer_'.$lang],
                    'answer_raw'=>  htmlspecialchars(strip_tags($q['answer_'.$lang])),
                    'is_active'=>  $q->is_active,
                    'created_at'=>  $q->created_at,
                ];
            });
        return $this->apiResponse(200, ['data' => ['resources' => $resources], 'message' => []]);
    }
}
