<?php

namespace App\Http\Controllers\Api\Freelancer;

use App\Category;
use App\Freelancer;
use App\FreelancerServices;
use App\FreelancerUserMessage;
use App\FreelancerWorkshop;
use App\Http\Controllers\Admin\Common;
use App\Settings;
use App\Slideshow;
use App\UserNotification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Calculation\Web\Service;

class MessagesController extends Controller
{
    public function getMessages(Request $request)
    {
//        $resources = FreelancerUserMessage::where('freelancer_id', Auth::id())
//            ->when($request->q  , function ($query) use($request){
//                $query->whereHas('user' , function ($query2) use($request){
//                    $query2->where('first_name' , 'like' , '%'. $request->q .'%')
//                    ->orWhere('last_name' , 'like' , '%'. $request->q .'%');
//                })->with('user:id,first_name,last_name,image');
//            } , function ($query) {
//                $query->with('user:id,first_name,last_name,image');
//            })
//            ->get()->groupBy('user_id')->map(function ($item) {
//               return $item->last();
//            });
//        $resources = $resources->toArray();
//        $resources = array_values($resources);
        $settingInfo = Settings::where("keyname", "setting")->first();
        $pageNumber = $request->hasHeader('per-page') ? (int) $request->header('per-page') : $settingInfo->item_per_page_back ;
        $resources = DB::query()->fromSub(function ($query) use($request) {
            $query->From('freelancer_user_messages')
                ->where('freelancer_id', Auth::id())
                ->selectRaw('max(`freelancer_user_messages`.`id`) as mId')
                ->groupBy('freelancer_user_messages.user_id');
        }, 'a')
            ->leftJoin('freelancer_user_messages' , 'a.mId' , 'freelancer_user_messages.id')
            ->where('freelancer_user_messages.freelancer_inbox_delete' , 0)
            ->select('freelancer_user_messages.*' ,
                'users.first_name' ,
                'users.last_name' ,
                'users.image' ,
                DB::raw('IF(`blocked_user_freelancer`.`freelancer_id`,true,false) as block ')
            )
            ->join('users', function($join) use($request){
                $join->on('users.id' , 'freelancer_user_messages.user_id');
                if ( ! empty($request->q) )
                    $join->where(function ($join) use($request){
                        $join->where('users.first_name' , 'like' , '%'. $request->q .'%')
                            ->orWhere('users.last_name' , 'like' , '%'. $request->q .'%');
                    });
            } )
            ->leftJoin('blocked_user_freelancer', function($join){
                $join->on('blocked_user_freelancer.freelancer_id', '=', 'freelancer_user_messages.freelancer_id')
                    ->on('blocked_user_freelancer.user_id', 'freelancer_user_messages.user_id');
            })
            ->orderByDesc('created_at')
            ->paginate($pageNumber);
        $resources->getCollection()->transform(function ($item) {
            $result = get_object_vars($item);
            $result['user'] = [
                'id' => $item->user_id,
                'first_name' => $item->first_name,
                'last_name' => $item->last_name,
                'image' => $item->image,
            ];
            $result['freelancer'] = [
                'id' => $item->freelancer_id,
                'name' => Auth::user()->name,
                'image' => Auth::user()->image,
            ];
            unset($result['first_name'],$result['last_name'],$result['image']);
            return $result;
        });
        return $this->apiResponse(200, ['data' => ['messages' => $resources], 'message' => []]);
    }


    public function getUserMessages(Request $request)
    {
        $user = auth()->user();
        $block = false;
        if ( $user->blockedUser()->where('user_id', $request->user_id)->first() != null  )
            $block = true;
        $settingInfo = Settings::where("keyname", "setting")->first();
        $pageNumber = $request->hasHeader('per-page') ? (int) $request->header('per-page') : $settingInfo->item_per_page_back ;

        $resources = FreelancerUserMessage::selectRaw('freelancer_user_messages.*')->selectRaw((int) $block .' as `block`')->
            with('freelancer:id,name,image', 'user:id,first_name,last_name,image')
            ->where(['freelancer_id'=> Auth::id(), 'user_id'=>$request->user_id , 'freelancer_delete' => 0 ])
            ->orderByDesc('created_at')
            ->paginate($pageNumber);
        FreelancerUserMessage::where(['freelancer_id'=> Auth::id(), 'user_id'=>$request->user_id ])->orderByDesc('created_at')->where('freelancerRead' , 0 )->update(['freelancerRead' => 1 , 'isPushSend' => 1 ]);
        return $this->apiResponse(200, ['data' => ['block' =>$block ,'messages' => $resources], 'message' => []]);
    }

    public function storeMessages(Request $request)
    {
        $user = auth()->user();
        if ( $user->blockedUser()->where('user_id', $request->user_id)->first() != null  )
            return $this->apiResponse(403, ['data' => [], 'message' => [trans('api.UserBlockYou')]]);

        $validator = Validator::make($request->all(), [
            'user_id' => ['required', 'numeric', 'exists:users,id'],
            'message_type' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->apiResponse(422, ['data' => [], 'message' => $validator->errors()->all()]);
        }

        if (isset($request->lat) && !isset($request->lng))
            return $this->apiResponse(422, ['data' => [], 'message' => ['lng is required']]);

        if (isset($request->lng) && !isset($request->lat))
            return $this->apiResponse(422, ['data' => [], 'message' => ['lat is required']]);

        if (isset($request->lng) && isset($request->lat) || isset($request->message) || $request->hasFile('file')) {
            $cover_image = Common::uploadImage($request, 'file', 'messages', 0, 0, 0, 0);
            $listMessages = $user->messages()->create([
                'user_id' => $request->user_id,
                'freelancer_id' => Auth::id(),
                'type' => 'freelancer',
                'message' => $request->message,
                'message_type' => $request->message_type,
                'lat' => $request->lat,
                'long' => $request->lng,
                'file' => $cover_image ? '/uploads/messages/' . $cover_image : null,
                'userRead' => 0,
                'freelancerRead' => 1,
            ]);
            $listMessages = FreelancerUserMessage::selectRaw('freelancer_user_messages.*')->selectRaw('0 as `block`')->with('freelancer:id,name,image', 'user:id,first_name,last_name,image')->find($listMessages->id);
            UserNotification::add($request->user_id,Auth::id(),['newMessage' , $user->name ],'newMessage',['new_message'  => true , 'freelancer_id' => Auth::id()]);
        }else
            return $this->apiResponse(422, ['data' => [], 'message' => [trans('api.anythingNotFound')]]);

        return $this->apiResponse(200, ['data' => ['messages' => $listMessages], 'message' => [trans('api.messageSend')]]);
    }


    public function blockUser($id){
        $user = Auth::user();
        $user->blockedUser()->toggle($id);
        return $this->apiResponse(200, ['data' => [], 'message' => [trans('api.userBlocked')]]);
    }

    public function reportUser($id){
        $user = Auth::user();
        $user->ReportUser()->create([
            'user_id' =>$id ,
            'sendFrom' => 'Freelancer' ,
        ]);
        return $this->apiResponse(200, ['data' => [], 'message' => [trans('api.reportSend')]]);
    }

    public function clearChat($id){
        FreelancerUserMessage::where(['freelancer_id'=> Auth::id(), 'user_id'=>$id])->update(['freelancer_delete' => 1]);
        return $this->apiResponse(200, ['data' => [], 'message' => []]);
    }


    public function readChat($id){
        FreelancerUserMessage::where(['freelancer_id'=> Auth::id(), 'user_id'=>$id])->orderByDesc('created_at')->limit(5)->update(['freelancerRead' => 1 ]);
        return $this->apiResponse(200, ['data' => [], 'message' => []]);
    }
    public function unreadChat($id){
        FreelancerUserMessage::where(['freelancer_id'=> Auth::id(), 'user_id'=>$id])->orderByDesc('created_at')->limit(5)->update(['freelancerRead' =>0]);
        return $this->apiResponse(200, ['data' => [], 'message' => []]);
    }
    public function deleteInbox($id){
        FreelancerUserMessage::where(['freelancer_id'=> Auth::id(), 'user_id'=>$id])->orderByDesc('created_at')->limit(5)->update(['user_inbox_delete' =>1]);
        return $this->apiResponse(200, ['data' => [], 'message' => []]);
    }
}