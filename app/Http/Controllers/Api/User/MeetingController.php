<?php

namespace App\Http\Controllers\Api\User;

use App\Category;
use App\Freelancer;
use App\FreelancerUserMessage;
use App\FreelancerWorkshop;
use App\FreelancerNotification;
use App\Meeting;
use App\Slideshow;
use App\TimeCalender;
use App\User;
use App\UserNotification;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class MeetingController extends Controller
{
//    public function index(Request $request)
//    {
//        $resources = Freelancer::find($request->freelancer_id)
//            ->meetings()->with('user', 'slot', 'location');
//        return $this->apiResponse(200, ['data' => ['meetings' => $resources], 'message' => []]);
//    }
    public function getSlots(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'freelancer_id' => ['required'],
            'date' => ['required'],
        ]);

        if ($validator->fails()) {
            return $this->apiResponse(422, ['data' => [], 'message' => $validator->errors()->all()]);
        }

        $date = Carbon::parse($request->date)->format('Y-m-d');
       
        $data = TimeCalender::where(['freelancer_id'=> $request->freelancer_id, 'date' => $date , 'status' => 'free'])->orderBy('start_time')->get();
        return $this->apiResponse(200, ['data' => ['slots' => $data], 'message' => []]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'freelancer_id' => 'required|exists:freelancers,id',
            'slot_id' => 'required|exists:time_calenders,id',
            'freelancer_location_id' => 'nullable|exists:freelancer_addresses,id',
            'user_location_id' => 'nullable|exists:addresses,id',
        ]);

        if ($validator->fails()) {
            return $this->apiResponse(422, ['data' => [], 'message' => $validator->errors()->all()]);
        }

        $user=Auth::user();
        DB::beginTransaction();
        try {
            $freelancer = Freelancer::findOrFail($request->freelancer_id);
            if (!$freelancer->is_active or $freelancer->offline or \Illuminate\Support\Carbon::now()->gte($freelancer->expiration_date)) {
                DB::rollBack();
                return $this->apiResponse(404, ['data' => [], 'message' => [trans('api.FreelancerDeactivate')]]);
            }
            if (!$freelancer->set_a_meeting) {
                DB::rollBack();
                return $this->apiResponse(404, ['data' => [], 'message' => [trans('api.deactivateMeeting')]]);
            }

            if (
                ($request->freelancer_location_id == null and $request->user_location_id == null) or
                ($request->freelancer_location_id == null and $freelancer->location_type == "my") or
                ($request->user_location_id == null and $freelancer->location_type == "any")) {
                DB::rollBack();
                return $this->apiResponse(400, ['data' => ["freelancer_location" => $freelancer->location_type], 'message' => [trans('api.selectLocation')]]);
            }
            if ($request->user_location_id != null and ($freelancer->location_type == "both" or $freelancer->location_type == "any")) {
                $userAddress = $user->address()->findOrFail($request->user_location_id);
                if (!$freelancer->areas()->where('freelancer_areas.area_id', $userAddress->area_id)->exists()) {
                    DB::rollBack();
                    return $this->apiResponse(400, ['data' => ["freelancer_location" => $freelancer->location_type], 'message' => [trans('api.selectLocationOtherArea')]]);
                }
            }
            
            $time = $freelancer->calendar()->where('status', 'free')->findOrFail($request->slot_id);
            
            $resource = new Meeting();
            $resource->user_id = Auth::id();
            $resource->freelancer_id = $freelancer->id;
            $resource->time_piece_id = $time->id;
            $resource->date = $time->date;
            $resource->time = $time->start_time;
            $resource->location_id = $request->freelancer_location_id;
            $resource->area_id = $request->user_location_id;
            $resource->save();


            $time->status = "booked";
            $time->bookedable_id = $resource->id;
            $time->bookedable_type = Meeting::class ;
            $time->save();
            FreelancerNotification::add($resource->user_id,$resource->freelancer_id,['bookingMeeting' , $user->Fullname , $resource->date .' '.$resource->time ],'bookingMeeting',['booking_id' => $resource->id]);
            DB::commit();
            return $this->apiResponse(200, ['data' => [], 'message' => [trans('api.user.booked.meeting')]]);
        } catch(ModelNotFoundException $exception)  {
            DB::rollBack();
            return $this->apiResponse(404, ['data' => [ 'model' =>$exception->getModel() , 'ids' => $exception->getIds() ], 'message' => [$exception->getMessage()]]);
        } catch ( \Exception $exception){
            DB::rollBack();
            return $this->apiResponse(500, ['data' => [$exception->getMessage()], 'message' => [trans('api.canNotSetMeeting')]]);
        }
    }

    public function cancel($id){
        $user=Auth::user();
        $order = Meeting::where('user_id' , $user->id )
            ->with(['slot' , 'freelancer'])
            ->findOrfail($id);

        if ( Carbon::now()->addHours(12)->gte( Carbon::parse($order->date .' '.$order->time)->format('Y-m-d H:i:s'))){
            return $this->apiResponse(400, ['data' => [], 'message' => [trans('api.canNotSetMeeting12H')]]);
        }
        FreelancerNotification::add($order->user_id,$order->freelancer_id,['cancellationMeeting' , $user->Fullname , $order->date .' '.$order->time ],'cancellationMeeting',['meeting_id' => $order->id]);
        UserNotification::add($order->user_id,$order->freelancer_id,['cancellationMeeting' , $order->freelancer->name , $order->date .' '.$order->time ],'cancellationMeeting',['meeting_id' => $order->id]);
        $timeSlot = $order->slot;
        if ( $timeSlot != null ) {
            $timeSlot->status = 'free';
            $timeSlot->bookedable_id = null;
            $timeSlot->bookedable_type = null;
            if ( $timeSlot->save() ) {
                $order->delete();
            }
        } else
            $order->delete();
        return $this->apiResponse(200, ['data' => [], 'message' => [trans('api.user.cancellation.meeting')]]);
    }

    public function reschedule(Request $request , $id,$slotId)
    {
        $request->merge(['slot_id' => $slotId]);
        $validator = Validator::make($request->all(), [
            'slot_id' => 'required|exists:time_calenders,id',
        ]);
        if ($validator->fails()) {
            return $this->apiResponse(422, ['data' => [], 'message' => $validator->errors()->all()]);
        }

        $user=Auth::user();
        $resource = Meeting::where('user_id' , $user->id )
            ->with(['slot'])
            ->findOrfail($id);
        DB::beginTransaction();
        try {
            $freelancer = $resource->freelancer;
            $lastTime = $resource->slot;
            $dateOfLastOrder = Carbon::createFromFormat('Y-m-d H:i:s', $lastTime->date .' '. $lastTime->start_time)->subHours(12);
            $dateOfNow = Carbon::now();
            if ( $dateOfLastOrder->lte($dateOfNow)){
                DB::rollBack();
                return $this->apiResponse(404, ['data' => [], 'message' => [trans('api.rescheduleMeeting12H')]]);
            }
            $time = $freelancer->calendar()->where('status', 'free')->findOrFail($request->slot_id);
            $lastTime->status = "free";
            $lastTime->bookedable_id = null;
            $lastTime->bookedable_type = null ;
            $time->status = "booked";
            $time->bookedable_id = $resource->id;
            $time->bookedable_type = Meeting::class ;
            $time->save();
            $lastTime->save();
            FreelancerNotification::add($resource->user_id,$resource->freelancer_id,['reschedule' , $user->Fullname , $resource->date .' '.$resource->time , [] , $time->date .' '. $time->start_time ],'reschedule',['meeting_id' => $resource->id]);
            $resource->date = $time->date;
            $resource->time = $time->start_time;
            $resource->time_piece_id = $time->id;
            $resource->save();
            DB::commit();
            return $this->apiResponse(200, ['data' => [], 'message' => [trans('api.rescheduleMeeting')]]);
        } catch(ModelNotFoundException $exception)  {
            DB::rollBack();
            return $this->apiResponse(404, ['data' => [ 'model' =>$exception->getModel() , 'ids' => $exception->getIds() ], 'message' => [$exception->getMessage()]]);
        } catch ( \Exception $exception){
            DB::rollBack();
            return $this->apiResponse(500, ['data' => [$exception->getMessage()], 'message' => [trans('api.canNotRescheduleMeeting')]]);
        }
    }

}
