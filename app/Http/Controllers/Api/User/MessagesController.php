<?php

namespace App\Http\Controllers\Api\User;

use App\Category;
use App\Freelancer;
use App\FreelancerNotification;
use App\FreelancerServices;
use App\FreelancerUserMessage;
use App\FreelancerWorkshop;
use App\Http\Controllers\Admin\Common;
use App\Settings;
use App\Slideshow;
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
//        $resources = FreelancerUserMessage::where('user_id', Auth::id())
//            ->when($request->q  , function ($query) use($request){
//                $query->whereHas('freelancer' , function ($query2) use($request){
//                    $query2->where('name' , 'like' , '%'. $request->q .'%')
//                        ->select('id','name','image');
//                })->with('freelancer:id,name,image');
//            } , function ($query) {
//                $query->with('freelancer:id,name,image');
//            })
//            ->get()->groupBy('freelancer_id')->map(function ($item) {
//               return $item->last();
//            });
//        $resources = $resources->toArray();
//        $resources = array_values($resources);
        $settingInfo = Settings::where("keyname", "setting")->first();
        $pageNumber = $request->hasHeader('per-page') ? (int) $request->header('per-page') : $settingInfo->item_per_page_back ;
        $resources = DB::query()->fromSub(function ($query) use($request) {
            $query->From('freelancer_user_messages')
                ->where('user_id', Auth::id())
                ->selectRaw('max(`freelancer_user_messages`.`id`) as mId')
                ->groupBy('freelancer_user_messages.freelancer_id');
        }, 'a')
            ->leftJoin('freelancer_user_messages' , 'a.mId' , 'freelancer_user_messages.id')
            ->where('freelancer_user_messages.user_inbox_delete' , 0)
            ->select('freelancer_user_messages.*' ,
                'freelancers.name' ,
                'freelancers.image' ,
                DB::raw('IF(`blocked_user_freelancer`.`user_id`,true,false) as block ')
            )
            ->join('freelancers', function($join) use($request){
                $join->on('freelancers.id' , 'freelancer_user_messages.freelancer_id');
                if ( ! empty($request->q) )
                    $join->where('freelancers.name' , 'like' , '%'. $request->q .'%');
            } )
            ->leftJoin('blocked_user_freelancer', function($join){
                $join->on('blocked_user_freelancer.freelancer_id', '=', 'freelancer_user_messages.freelancer_id')
                    ->on('blocked_user_freelancer.user_id', 'freelancer_user_messages.user_id');
            })
            ->orderByDesc('created_at')
            ->paginate($pageNumber);
        $resources->getCollection()->transform(function ($item) {
            $result = get_object_vars($item);
            $result['freelancer'] = [
                'id' => $item->freelancer_id,
                'name' => $item->name,
                'image' => $item->image,
            ];
            $result['user'] = [
                'id' => $item->user_id,
                'first_name' => Auth::user()->first_name,
                'last_name' => Auth::user()->last_name,
                'image' => Auth::user()->image,
            ];
            unset($result['name'],$result['image']);
            return $result;
        });
        return $this->apiResponse(200, ['data' => ['messages' => $resources], 'message' => []]);
    }


    public function getFreelancerMessages(Request $request)
    {
        $user = auth()->user();
        $block = false;
        if ( $user->blockedUser()->where('user_id', $request->user_id)->first() != null  )
            $block = true;
        $settingInfo = Settings::where("keyname", "setting")->first();
        $pageNumber = $request->hasHeader('per-page') ? (int) $request->header('per-page') : $settingInfo->item_per_page_back ;
        $resources = FreelancerUserMessage::selectRaw('freelancer_user_messages.*')->selectRaw((int) $block .' as `block`')->with('freelancer:id,name,image', 'user:id,first_name,last_name,image')->where(['user_id'=> Auth::id(), 'freelancer_id'=>$request->freelancer_id , 'user_delete' => 0])->orderByDesc('created_at')->paginate($pageNumber);
        FreelancerUserMessage::where(['user_id'=> Auth::id(), 'freelancer_id'=>$request->freelancer_id ])->orderByDesc('created_at')->where('userRead' , 0 )->update(['userRead' => 1 , 'isPushSend' => 1]);
        return $this->apiResponse(200, ['data' => ['block' =>$block ,'messages' => $resources], 'message' => []]);
    }

    public function storeMessages(Request $request)
    {
        $user = auth()->user();
        if ( $user->blockedFreelancer()->where('freelancer_id', $request->freelancer_id)->exists() )
            return $this->apiResponse(403, ['data' => [], 'message' => [trans('api.freelancerBlockYou')]]);

        $validator = Validator::make($request->all(), [
            'freelancer_id' => ['required', 'numeric', 'exists:freelancers,id'],
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
                'user_id' => Auth::id(),
                'freelancer_id' => $request->freelancer_id,
                'type' => 'user',
                'message' => $request->message,
                'message_type' => $request->message_type,
                'lat' => $request->lat,
                'long' => $request->lng,
                'file' => $cover_image ? '/uploads/messages/' . $cover_image : null,
                'userRead' => 1,
                'freelancerRead' => 0,
            ]);
            $listMessages = FreelancerUserMessage::selectRaw('freelancer_user_messages.*')->selectRaw('0 as `block`')->with('freelancer:id,name,image', 'user:id,first_name,last_name,image')->find($listMessages->id);
            FreelancerNotification::add(Auth::id(),$request->freelancer_id,['newMessage' , $user->Fullname ],'newMessage',['new_message'  => true , 'user_id' => Auth::id()]);
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
            'freelancer_id' =>$id ,
            'sendFrom' => 'User' ,
        ]);
        return $this->apiResponse(200, ['data' => [], 'message' => [trans('api.reportSend')]]);
    }

    public function clearChat($id){
        FreelancerUserMessage::where(['user_id'=> Auth::id(), 'freelancer_id'=>$id])->update(['user_delete' => 1]);
        return $this->apiResponse(200, ['data' => [], 'message' => []]);
    }

    public function readChat($id){
        FreelancerUserMessage::where(['user_id'=> Auth::id(), 'freelancer_id'=>$id])->orderByDesc('created_at')->limit(5)->update(['userRead' => 1 ]);
        return $this->apiResponse(200, ['data' => [], 'message' => []]);
    }
    public function unreadChat($id){
        FreelancerUserMessage::where(['user_id'=> Auth::id(), 'freelancer_id'=>$id])->orderByDesc('created_at')->limit(5)->update(['userRead' =>0]);
        return $this->apiResponse(200, ['data' => [], 'message' => []]);
    }
    public function deleteInbox($id){
        FreelancerUserMessage::where(['user_id'=> Auth::id(), 'freelancer_id'=>$id])->orderByDesc('created_at')->limit(5)->update(['user_inbox_delete' => 1]);
        return $this->apiResponse(200, ['data' => [], 'message' => []]);
    }
}