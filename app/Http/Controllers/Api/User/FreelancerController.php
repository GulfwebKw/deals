<?php

namespace App\Http\Controllers\Api\User;

use App\Category;
use App\Freelancer;
use App\FreelancerServices;
use App\Settings;
use App\TimeCalender;
use App\UserFreelancer;
use Carbon\CarbonPeriod;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FreelancerController extends Controller
{
    public function getFreelancers(Request $request , $category_id)
    {
        $settings = Settings::where("keyname", "setting")->first();
        $pageNumber = $request->hasHeader('per-page') ? (int) $request->header('per-page') : $settings->item_per_page_back ;
        $PriceFilter = $request->price_filter??null;
        $RateFilter = $request->rate_filter??null;
        $category = Category::where('is_active' , 1 )->findOrFail($category_id);
        $services = $category->freelancers()
            ->where('freelancers.is_active' , 1 )
            ->where('freelancers.offline' , 0 )
            ->whereDate('freelancers.expiration_date' , '>=', \Illuminate\Support\Carbon::now())
            ->with('rate')
            ->rates($RateFilter)
            ->service($PriceFilter)
            ->orderByDesc('id')
            ->paginate($pageNumber);
        return $this->apiResponse(200, ['data' => [ 'freelancers' => $services], 'message' => []]);
    }

    public function getSingleFreelancer(Request $request)
    {
        $freelancer = Freelancer::where('is_active' , 1 )
            ->where('offline' , 0 )->with(['rate', 'services', 'workshops', 'address' => function($query) { $query->where('disposable' , 0 ); $query->with('area.city.country'); }, 'categories', 'highlights.images' , 'areas' => function($query) {
                $query->where('is_active' , 1 )->with(['city' => function($query2){
                    $query2->where('is_active' , 1 )->with(['country' => function($query3){
                        $query3->where('is_active' , 1 );
                    }]);
                }]);
            }])->findOrFail($request->id);
        $data = UserFreelancer::where(['user_id'=> Auth::id(), 'freelancer_id'=> $freelancer->id])->first();
        if ($data)
            $freelancer['highlight'] = 1;
        else
            $freelancer['highlight'] = 0;

        $block = false;
        if ( $freelancer->blockedUser()->where('user_id', Auth::id())->first() != null  )
            $block = true;
        $freelancer['block'] = $block;
        return $this->apiResponse(200, ['data' => ['freelancer' => $freelancer], 'message' => []]);
    }

    public function getFreelancerServices(Request $request)
    {
        $freelancer = Freelancer::where('is_active' , 1 )
            ->where('offline' , 0 )
            ->whereDate('expiration_date' , '>=', \Illuminate\Support\Carbon::now())
            ->orderByDesc('id')
            ->findOrFail($request->id);
        return $this->apiResponse(200, ['data' => ['freelancer_services' => $freelancer->services], 'message' => []]);
    }

    public function getHighlightServices(Request $request)
    {
        $freelancer = Freelancer::where('is_active' , 1 )
            ->where('offline' , 0 )->findOrFail($request->id)->services()->where('highlight', 1)->orderByDesc('id')->get();
        return $this->apiResponse(200, ['data' => ['freelancer_highlight_services' => $freelancer], 'message' => []]);
    }

    public function getSingleService(Request $request)
    {
        $service = FreelancerServices::where(['id'=>$request->service_id, 'freelancer_id'=>$request->freelancer_id])->first();
        return $this->apiResponse(200, ['data' => ['service' => $service], 'message' => []]);
    }


    public function getCalendar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'freelancer_id' => ['required'],
            'year' => ['required'],
            'month' => ['required'],
        ]);

        if ($validator->fails()) {
            return $this->apiResponse(422, ['data' => [], 'message' => $validator->errors()->all()]);
        }

        $startDate = date('Y-m-1 0:0:0' , strtotime($request->year.'-'.$request->month.'-1'));
//        $EndDate = date('Y-m-t 23:59:59' , strtotime($request->year.'-'.$request->month.'-1'));
        $EndDate = Carbon::parse($request->year.'-'.$request->month.'-1')->addMonth()->endOfMonth()->format('Y-m-d 23:59:59');
        $periods = CarbonPeriod::create($startDate, $EndDate);
        $results = [];
        foreach ( $periods as $period ){
            $results[$period->format('Y-m-d')] = [
                'date' => $period->format('Y-m-d'),
                'day' => $period->format('d'),
                'weekNumber' => $period->format('N'),
                'weekDay' => $period->format('l'),
                'weekDayShort' => $period->format('D'),
                'status' => 'closed',
                'slots' => []
            ];
        }
        $freeDate = TimeCalender::where('freelancer_id' , $request->freelancer_id)
            ->whereBetween('date', [$startDate , $EndDate])
            ->where('status', 'free')
            ->groupBy('date')
            ->get();
        $allDate = TimeCalender::where('freelancer_id' , $request->freelancer_id)
            ->whereBetween('date', [$startDate , $EndDate])
            ->groupBy('date')
            ->get();
        foreach ( $allDate as $date ){
            $results[$date->date]['status'] = 'busy';
        }
        foreach ( $freeDate as $date ){
            $results[$date->date]['status'] = 'free';
            $results[$date->date]['slots'] = TimeCalender::where(['freelancer_id'=> $request->freelancer_id, 'date' => $date->date , 'status' => 'free'])->select('id' , 'start_time' , 'end_time')->orderBy('start_time')->get();
        }
        return $this->apiResponse(200, ['data' => ['days' => array_values($results)], 'message' => []]);
    }
}