<?php

namespace App\Http\Controllers\Api\User;

use App\Bill;
use App\Category;
use App\Freelancer;
use App\FreelancerUserMessage;
use App\FreelancerWorkshop;
use App\Http\Resources\MyMeetingResource;
use App\ServiceUserOrders;
use App\Settings;
use App\User;
use App\WorkshopOrder;
use App\Slideshow;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MyWorkShopsResource;
use App\Http\Resources\MyServicesResource;
use App\Http\Resources\UserNotificationResource;
use App\UserNotification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use DB;

class DealsController extends Controller
{

    public function myDeals()
    {
        $user = Auth::user();
        config(['translatable.locale' => request()->header('accept-language')]);
        $locale = request()->header('accept-language');
        $data_workshops = MyWorkShopsResource::collection($user->workshops()
            ->where('payment_status', 'paid')
            ->whereHas('workshop', function ($q) {
                $q->whereDate('date', '>',  Carbon::yesterday());
            })->with(['workshop', 'workshop.freelancer'])
            ->get())->resolve();
        $data_service = MyServicesResource::collection(ServiceUserOrders::whereIn('order_id', $user->serviceOrder()->get()->pluck('id')->toArray())
            ->whereIn('status', ['booked', 'freelancer_reschedule', 'user_reschedule', 'admin_reschedule'])
            ->whereDate('date', '>',  Carbon::yesterday())
            ->with(['service', 'timeSlot', 'service.freelancer', 'service.category', 'service.category.lan' => function ($query) use ($locale) {
                $query->where('locale', $locale);
            }])
            ->get())->resolve();

        $data_Meeting = MyMeetingResource::collection($user->mettings()->whereHas('slot', function ($q) {
            $q->whereDate('date', '>',  Carbon::yesterday());
        })->with(['freelancer', 'slot'])
            ->get())->resolve();

        $userNotifications = UserNotificationResource::collection($user->notification()
            ->select('*', 'created_at as date')->get())->resolve();

        $datas = array_merge($data_workshops, $data_service, $data_Meeting, $userNotifications);
        usort($datas, function ($a, $b) {
            // $t1 = strtotime($a['date']);
            // $t2 = strtotime($b['date']);
            // return $t1 - $t2;
            
            $t1 = strtotime($a['created_at']);
            $t2 = strtotime($b['created_at']);
            return $t2 - $t1;
        });
        return $this->apiResponse(200, ['data' => ['deals' => $datas], 'message' => []]);
    }

    public function orders(Request $request)
    {
        $user = Auth::user();
        config(['translatable.locale' => request()->header('accept-language')]);
        $locale = request()->header('accept-language');
        //        $data_workshops = MyWorkShopsResource::collection($user->workshops()->with(['workshop' , 'workshop.freelancer'])->get())->resolve();
        //        $data_service = MyServicesResource::collection(ServiceUserOrders::whereIn('order_id' , $user->serviceOrder()->get()->pluck('id')->toArray() )
        //            ->with(['service' , 'timeSlot', 'service.freelancer', 'service.category', 'service.category.lan' => function($query) use($locale) {
        //                $query->where('locale' , $locale );
        //            }])->get())->resolve();

        //        $data_Meeting = MyMeetingResource::collection($user->mettings()->with(['freelancer','slot'])->get())->resolve();
        //        $datas = array_merge($data_workshops,$data_service,$data_Meeting);
        //        usort($datas, function($a, $b) {
        //            $t1 = strtotime($a['created_at']);
        //            $t2 = strtotime($b['created_at']);
        //            return $t1 - $t2;
        //        });
        //        return $this->apiResponse(200, ['data' => $datas, 'message' => []]);


        $settings = Settings::where("keyname", "setting")->first();
        $pageNumber = $request->hasHeader('per-page') ? (int) $request->header('per-page') : $settings->item_per_page_back;
        $queryService = ServiceUserOrders::query();
        $queryService->whereIn('order_id', $user->serviceOrder()->get()->pluck('id')->toArray());
        $queryService->whereNotIn('status', ['preorder', 'not_pay']);
        $queryService->leftJoin('freelancers', 'freelancers.id', 'service_user_orders.freelancer_id');
        $queryService->leftJoin('freelancer_services', 'freelancer_services.id', 'service_user_orders.service_id');
        $queryService->select('service_user_orders.id', 'service_user_orders.freelancer_id', 'freelancers.name as freelancer_name',  'freelancers.image as freelancer_avatar', 'freelancer_services.name as packageName', 'service_user_orders.created_at', 'freelancers.email', 'freelancers.phone', 'service_user_orders.date', 'service_user_orders.time');



        $queryWorkShop = WorkshopOrder::query();
        $queryWorkShop->where('workshop_orders.user_id',   $user->id);
        $queryWorkShop->whereNotIn('payment_status', ['waiting']);
        $queryWorkShop->leftJoin('freelancers', 'freelancers.id', 'workshop_orders.freelancer_id');
        $queryWorkShop->leftJoin('freelancer_workshops', 'freelancer_workshops.id', 'workshop_orders.workshop_id');
        $queryWorkShop->leftJoin('freelancer_workshop_translations', function ($join) {
            $join->on('freelancer_workshop_translations.freelancer_workshop_id', 'workshop_orders.workshop_id')
                ->where('freelancer_workshop_translations.locale', 'en');
        });
        $queryWorkShopLast = $queryWorkShop->select('workshop_orders.id', 'workshop_orders.freelancer_id', 'freelancers.name as freelancer_name',  'freelancers.image as freelancer_avatar', 'freelancer_workshop_translations.name as packageName', 'workshop_orders.created_at', 'freelancers.email', 'freelancers.phone', 'freelancer_workshops.date', 'freelancer_workshops.from_time');


        $queryBill = Bill::query();
        $queryBill->where('bills.user_id',   $user->id);
        $queryBill->whereNotIn('payment_status', ['waiting']);
        $queryBill->leftJoin('freelancers', 'freelancers.id', 'bills.freelancer_id');
        $queryBillLast = $queryBill->select('bills.id', 'bills.freelancer_id', 'freelancers.name as freelancer_name',  'freelancers.image as freelancer_avatar', 'bills.description as packageName', 'bills.created_at', 'freelancers.email', 'freelancers.phone')
            ->selectRaw(" DATE(bills.expire_at) as date, Time(bills.expire_at) as time");

        $datas = $queryService->union($queryWorkShopLast)->union($queryBillLast)->orderByDesc('created_at')->paginate($pageNumber);
        return $this->apiResponse(200, ['data' => ['orders' => $datas], 'message' => []]);
    }
}
