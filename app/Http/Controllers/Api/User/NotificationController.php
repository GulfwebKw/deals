<?php

namespace App\Http\Controllers\Api\User;

use App\FreelancerNotification;
use App\FreelancerUserMessage;
use App\Resume;
use App\ServiceUserOrders;
use App\Settings;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    /**
     *
     *  ADD NEW Notification
    $notifications = new FreelancerNotification();
    $notifications->description = 'this is sample <b>Description</b> to send you.';
    $notifications->image = 'book';
    $notifications->user_id = 2;
    $notifications->freelancer_id = $user->id ;
    $notifications->order_id = 29 ;
    $notifications->save();
     */
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $settingInfo = Settings::where("keyname", "setting")->first();
        $pageNumber = $request->hasHeader('per-page') ? (int) $request->header('per-page') : $settingInfo->item_per_page_back ;
        $user = Auth::user();
        $notifications = $user->notification()->orderByDesc('is_read')->orderByDesc('id')->paginate($pageNumber);
        $user->notification()->whereIn('id' , $notifications->pluck('id') )->update(['is_read' => 1 ]);
        return $this->apiResponse(200, ['data' => ['notifications' => $notifications], 'message' => []]);
    }


    public function status(){
        $user = Auth::user();
        $messages = FreelancerUserMessage::query()->whereIn('id' , function ($query){
            $query->From('freelancer_user_messages')
                ->where('user_id', Auth::id())
                ->selectRaw('max(`freelancer_user_messages`.`id`) as mId')
                ->groupBy('freelancer_user_messages.freelancer_id');
        })->where('userRead' , 0)->count() > 0 ;
        $workshops = $user->workshops()
            ->where('payment_status' , 'paid')
            ->whereHas('workshop', function($q){
                $q->whereDate('date','>',  Carbon::yesterday());
            })->count() > 0 ;
        $service = ServiceUserOrders::whereIn('order_id' , $user->serviceOrder()->get()->pluck('id')->toArray() )
            ->whereIn('status' , ['booked' , 'freelancer_reschedule' , 'user_reschedule' , 'admin_reschedule'] )
            ->whereDate('date','>',  Carbon::yesterday())
            ->count() > 0;
        $meetings = $user->mettings()->whereHas('slot', function($q){
                        $q->whereDate('date','>',  Carbon::yesterday());
                    })->count() > 0 ;
        $notification = $user->notification()->where('is_read' , 0 )->count() > 0 ;

        return $this->apiResponse(200, ['data' => [
            'messages'=> $messages,
            'deals'=> ($workshops or $service or $meetings),
            'notification'=> $notification,
            'notification_and_message'=> ($notification or $messages),
        ], 'message' => ['success']]);

    }
}
