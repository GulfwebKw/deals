<?php

namespace App\Http\Controllers\Api\Freelancer;

use App\Freelancer;
use App\Http\Controllers\Admin\Common;
use App\Time_piece;
use App\TimeCalender;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class calendarController extends Controller
{
    private $minSlotTime = 60; // 120
    private $maxSlotTime = 180;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $user = Auth::user();
        $dates = $user->calendar()->orderBy('date')->orderBy('date')->orderBy('start_time')->get();
        return $this->apiResponse(200, ['data' => ['dates' => $dates], 'message' => []]);
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
            'details' => 'required|array|min:1',
            'details.*.date' => 'required|date|after_or_equal:today|before:' . ($user->expiration_date ?? "1990-01-01"),
            'details.*.time.*.start_time' => 'required',
            'details.*.time.*.end_time' => 'required',
            'details.*.time.*.buffer' => 'required|numeric|min:0',
        ]);
        /* @var $user Freelancer */
        DB::beginTransaction();
        foreach ($request->details as $detail) {
            foreach ($detail['time'] as $time) {
                $timeCalender = new TimeCalender();
                $timeCalender->freelancer_id = $user->id;
                $timeCalender->date = $detail['date'];
                $timeCalender->status = 'free';
                if (strtotime($time['end_time']) - strtotime($time['start_time']) < $this->minSlotTime * 60 or strtotime($time['end_time']) - strtotime($time['start_time']) > $this->maxSlotTime * 60) {
                    DB::rollBack();
                    return $this->apiResponse(400, ['data' => ['time' => $time, 'date' => $detail['date']], 'message' => [trans('api.slotTime', ['min' => $this->minSlotTime, 'max' => $this->maxSlotTime])]]);
                }
                $timeCalender->start_time = $time['start_time'];
                $timeCalender->end_time = $time['end_time'];
                $timeCalender->buffer = $time['buffer'];
                $timeCalender->end_buffer = date("H:i", strtotime($time['end_time']) + ($time['buffer'] * 60));
                if ($timeCalender->canCreate()) {
                    if (!$timeCalender->save()) {
                        DB::rollBack();
                        return $this->apiResponse(500, ['data' => [], 'message' => [trans('api.errorSaveTime')]]);
                    }
                } else {
                    DB::rollBack();
                    return $this->apiResponse(400, ['data' => ['time' => $time, 'date' => $detail['date']], 'message' => [trans('api.slotInSlot')]]);
                }
            }
        }
        DB::commit();
        return $this->apiResponse(200, ['data' => [], 'message' => [trans('api.slotMade')]]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeV2(Request $request)
    {
        $user = Auth::user();
        $this->validate($request, [
            'date' => 'required|date|after_or_equal:today|before:' . ($user->expiration_date ?? "1990-01-01"),
            'time.*.start_time' => 'required',
            'time.*.end_time' => 'required',
            'time.*.buffer' => 'required|numeric|min:0',
        ]);
        /* @var $user Freelancer */
        DB::beginTransaction();
        foreach ($request->time as $time) {
            $timeCalender = new TimeCalender();
            $timeCalender->freelancer_id = $user->id;
            $timeCalender->date = $request->date;
            $timeCalender->status = 'free';
            if (strtotime($time['end_time']) - strtotime($time['start_time']) < $this->minSlotTime * 60 or strtotime($time['end_time']) - strtotime($time['start_time']) > $this->maxSlotTime * 60) {
                DB::rollBack();
                return $this->apiResponse(400, ['data' => ['time' => $time, 'date' => $request->date], 'message' => [trans('api.slotTime', ['min' => $this->minSlotTime, 'max' => $this->maxSlotTime])]]);
            }
            $timeCalender->start_time = date("H:i", (strtotime($time['start_time'])));
            $timeCalender->end_time = date("H:i", (strtotime($time['end_time'])));
            $timeCalender->buffer = $time['buffer'];
            $timeCalender->end_buffer = date("H:i", strtotime($time['end_time']) + ($time['buffer'] * 60));

            if ($timeCalender->canCreate()) {
                if (!$timeCalender->save()) {
                    DB::rollBack();
                    return $this->apiResponse(500, ['data' => [], 'message' => [trans('api.errorSaveTime')]]);
                }
            } else {
                DB::rollBack();
                return $this->apiResponse(400, ['data' => ['time' => $time, 'date' => $request->date], 'message' => [trans('api.slotInSlot')]]);
            }
        }
        DB::commit();
        return $this->apiResponse(200, ['data' => [], 'message' => [trans('api.slotMade')]]);
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
        if (is_numeric($id))
            $dates = $user->calendar()->findOrFail($id);
        else
            $dates = $user->calendar()->where('date', $id)->orderBy('date')->orderBy('start_time')->get();
        return $this->apiResponse(200, ['data' => ['dates' => $dates], 'message' => []]);
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
        $user = Auth::user();
        $this->validate($request, [
            'date' => 'required|date|after_or_equal:today|before:' . ($user->expiration_date ?? "1990-01-01"),
            'start_time' => 'required',
            'end_time' => 'required',
            'buffer' => 'required|numeric|min:0',
        ]);
        if (strtotime($request->end_time) - strtotime($request->start_time) < $this->minSlotTime * 60 or strtotime($request->end_time) - strtotime($request->start_time) > $this->maxSlotTime * 60) {
            return $this->apiResponse(400, ['data' => [], 'message' => [trans('api.slotTime', ['min' => $this->minSlotTime, 'max' => $this->maxSlotTime])]]);
        }
        $timeCalender = $user->calendar()->where('status', 'free')->findOrFail($id);
        $timeCalender->date = $request->date;
        $timeCalender->start_time = $request->start_time;
        $timeCalender->end_time = $request->end_time;
        $timeCalender->buffer = $request->buffer;
        $timeCalender->end_buffer = date("H:i", strtotime($request->end_time) + ($request->buffer * 60));
        if ($timeCalender->canCreate($timeCalender->id)) {
            if (!$timeCalender->save()) {
                return $this->apiResponse(500, ['data' => [], 'message' => [trans('api.errorSaveTime')]]);
            }
        } else {
            return $this->apiResponse(400, ['data' => [], 'message' => [trans('api.slotInSlot')]]);
        }
        return $this->apiResponse(200, ['data' => [], 'message' => [trans('api.slotMade')]]);
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
        $dates = $user->calendar()->where('status', 'free')->findOrFail($id)->delete();
        return $this->apiResponse(200, ['data' => ['dates' => $dates], 'message' => [trans('api.slotDelete')]]);
    }


    private function prepare_time_slots($starttime, $endtime, $duration)
    {

        $time_slots = array();
        $start_time    = strtotime($starttime); //change to strtotime
        $end_time      = strtotime($endtime); //change to strtotime

        $add_mins  = $duration * 60;
        $i = 0;
        while ($start_time < $end_time) // loop between time
        {
            if ($start_time + $add_mins > $end_time) {
                return $time_slots;
            }
            $time_slots[$i]['start'] = date("H:i", $start_time);
            $time_slots[$i]['end'] = date("H:i", $start_time + $add_mins);
            $start_time += $add_mins; // to check endtime
            $i++;
        }
        return $time_slots;
    }
}
