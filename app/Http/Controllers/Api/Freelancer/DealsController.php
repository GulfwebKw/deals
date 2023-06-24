<?php

namespace App\Http\Controllers\Api\Freelancer;


use App\Bill;
use App\FreelancerNotification;
use App\Http\Resources\UserMeetingResource;
use App\Http\Resources\UserServicesResource;
use App\Http\Resources\UserWorkShopsResource;
use App\Meeting;
use App\ServiceUserOrders;
use App\Settings;
use App\UserNotification;
use App\WorkshopOrder;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class DealsController extends Controller
{

    public function calendar(Request $request)
    {
        $user = Auth::user();
        config(['translatable.locale' => request()->header('accept-language')]);
        $locale = request()->header('accept-language');

//        $data_workshops = UserWorkShopsResource::collection($user->workshops()
//            ->when($request->has('date'), function ($query) use ($request) {
//                $query->whereDate('date', '>=', Carbon::parse($request->date));
//            }, function ($query) {
//                $query->whereDate('date', '>',  Carbon::yesterday());
//            })
//            ->get())->resolve();
        $data_service = UserServicesResource::collection(ServiceUserOrders::where('freelancer_id', $user->id)
            ->whereIn('status', ['booked', 'freelancer_reschedule', 'user_reschedule', 'admin_reschedule'])
            ->when($request->has('date'), function ($query) use ($request) {
                $query->whereDate('date', '>=', Carbon::parse($request->date));
            }, function ($query) {
                $query->whereDate('date', '>',  Carbon::yesterday());
            })
            ->with(['service', 'timeSlot', 'order.user', 'service.category', 'service.category.lan' => function ($query) use ($locale) {
                $query->where('locale', $locale);
            }])->get())->resolve();

        $data_Meeting = UserMeetingResource::collection($user->mettings()
            ->when($request->has('date'), function ($query) use ($request) {
                $query->whereHas('slot', function ($q) use ($request) {
                    $q->whereDate('date',  '>=', Carbon::parse($request->date));
                });
            }, function ($query) {
                $query->whereHas('slot', function ($q) {
                    $q->whereDate('date', '>',  Carbon::yesterday());
                });
            })
            ->with(['user', 'slot'])->get())->resolve();
//        $datas = array_merge($data_workshops, $data_service, $data_Meeting);
        $datas = array_merge( $data_service, $data_Meeting);
        usort($datas, function ($a, $b) {
            $t1 = strtotime($a['date']);
            $t2 = strtotime($b['date']);
            return $t1 - $t2;
        });
        return $this->apiResponse(200, ['data' => $datas, 'message' => []]);
    }

    public function orders(Request $request)
    {
        $settings = Settings::where("keyname", "setting")->first();
        $pageNumber = $request->hasHeader('per-page') ? (int) $request->header('per-page') : $settings->item_per_page_back;
        $user = Auth::user();
        $queryService = ServiceUserOrders::query();
        $queryService->where('service_user_orders.freelancer_id',   $user->id);
        $queryService->whereNotIn('status', ['preorder', 'not_pay']);
        $queryService->leftJoin('user_orders', 'user_orders.id', 'service_user_orders.order_id');
        $queryService->leftJoin('users', 'users.id', 'user_orders.user_id');
        $queryService->leftJoin('freelancer_services', 'freelancer_services.id', 'service_user_orders.service_id');
        $queryService->select('service_user_orders.id', 'users.id as userId', 'users.first_name', 'users.last_name', 'freelancer_services.name as packageName', 'service_user_orders.created_at', 'service_user_orders.status', 'service_user_orders.price', 'service_user_orders.commission', 'service_user_orders.earn');

        $queryWorkShop = WorkshopOrder::query();
        $queryWorkShop->where('workshop_orders.freelancer_id',   $user->id);
        $queryWorkShop->whereNotIn('payment_status', ['waiting']);
        $queryWorkShop->leftJoin('users', 'users.id', 'workshop_orders.user_id');
        $queryWorkShop->leftJoin('freelancer_workshop_translations', function ($join) {
            $join->on('freelancer_workshop_translations.freelancer_workshop_id', 'workshop_orders.workshop_id')
                ->where('freelancer_workshop_translations.locale', 'en');
        });
        $queryWorkShopLast = $queryWorkShop->select('workshop_orders.id', 'users.id as userId', 'users.first_name', 'users.last_name', 'freelancer_workshop_translations.name as packageName', 'workshop_orders.created_at', 'workshop_orders.payment_status', 'workshop_orders.amount as price', 'workshop_orders.commission', 'workshop_orders.earn');


        $queryBill = Bill::query();
        $queryBill->where('bills.freelancer_id',   $user->id);
        $queryBill->whereNotIn('payment_status', ['waiting']);
        $queryBill->leftJoin('users', 'users.id', 'bills.user_id');
        $queryBillLast = $queryBill->select('bills.id', 'users.id as userId', 'users.first_name', 'users.last_name', 'bills.description as packageName', 'bills.created_at', 'bills.payment_status', 'bills.amount as price', 'bills.commission', 'bills.earn');

        $datas = $queryService->union($queryWorkShopLast)->union($queryBillLast)->orderByDesc('created_at')->paginate($pageNumber);
        return $this->apiResponse(200, ['data' => $datas, 'message' => []]);
    }

    public function earn(Request $request)
    {
        $user = Auth::user();
        $queryService = ServiceUserOrders::query();
        $queryService->where('service_user_orders.freelancer_id',   $user->id);
        $queryService->whereIn('status', ['booked', 'freelancer_reschedule', 'user_reschedule', 'admin_reschedule', 'completed']);
        $queryService->orderByDesc('created_at');
        $queryService->select(DB::raw('SUM(earn) as earn'), DB::raw('DATE(created_at)'));
        if ($request->period == 'day') {
            $startDate = date('Y-m-1 0:0:0');
            $EndDate = date('Y-m-t 23:59:59');
            $period = CarbonPeriod::create($startDate, $EndDate);
            $queryService->whereBetween('created_at', [$startDate, $EndDate]);
            $queryService->groupBy([DB::raw('DATE(created_at)')]);
            $queryService->addSelect(DB::raw('DATE(created_at) as period'));
        } elseif ($request->period == 'month') {
            $startDate = date('Y-1-1 0:0:0');
            $EndDate = date('Y-12-31 23:59:59');
            $period = CarbonPeriod::create($startDate, '1 month', $EndDate);
            $queryService->whereBetween('created_at', [$startDate, $EndDate]);
            $queryService->groupBy([DB::raw('DATE_FORMAT(created_at, \'%Y %d\')')]);
            $queryService->addSelect(DB::raw('DATE_FORMAT(created_at, \'%Y %b\') as period'));
        } else {
            $startDate = date('Y-1-1 0:0:0', time() - 60 * 60 * 24 * 365 * 10);
            $EndDate = date('Y-12-31 23:59:59');
            $period = CarbonPeriod::create($startDate, '1 year', $EndDate);
            $queryService->whereBetween('created_at', [$startDate, $EndDate]);
            $queryService->groupBy([DB::raw('YEAR(created_at)')]);
            $queryService->addSelect(DB::raw('YEAR(created_at) as period'));
        }
        $Service = $queryService->get()->toArray();

        $queryWorkShop = WorkshopOrder::query();
        $queryWorkShop->where('workshop_orders.freelancer_id',   $user->id);
        $queryWorkShop->where('payment_status', 'paid');
        $queryWorkShop->orderByDesc('created_at');
        $queryWorkShop->select(DB::raw('SUM(earn) as earn'), DB::raw('DATE(created_at)'));
        $queryWorkShop->whereBetween('created_at', [$startDate, $EndDate]);
        if ($request->period == 'day') {
            $queryWorkShop->groupBy([DB::raw('DATE(created_at)')]);
            $queryWorkShop->addSelect(DB::raw('DATE(created_at) as period'));
        } elseif ($request->period == 'month') {
            $queryWorkShop->groupBy([DB::raw('DATE_FORMAT(created_at, \'%Y %d\')')]);
            $queryWorkShop->addSelect(DB::raw('DATE_FORMAT(created_at, \'%Y %b\') as period'));
        } else {
            $queryWorkShop->groupBy([DB::raw('YEAR(created_at)')]);
            $queryWorkShop->addSelect(DB::raw('YEAR(created_at) as period'));
        }
        $WorkShop = $queryWorkShop->get()->toArray();


        $queryBill = Bill::query();
        $queryBill->where('bills.freelancer_id',   $user->id);
        $queryBill->where('bills.payment_status', 'paid');
        $queryBill->orderByDesc('bills.created_at');
        $queryBill->select(DB::raw('SUM(bills.earn) as earn'), DB::raw('DATE(bills.created_at)'));
        $queryBill->whereBetween('bills.created_at', [$startDate, $EndDate]);
        if ($request->period == 'day') {
            $queryBill->groupBy([DB::raw('DATE(bills.created_at)')]);
            $queryBill->addSelect(DB::raw('DATE(bills.created_at) as period'));
        } elseif ($request->period == 'month') {
            $queryBill->groupBy([DB::raw('DATE_FORMAT(bills.created_at, \'%Y %d\')')]);
            $queryBill->addSelect(DB::raw('DATE_FORMAT(bills.created_at, \'%Y %b\') as period'));
        } else {
            $queryBill->groupBy([DB::raw('YEAR(bills.created_at)')]);
            $queryBill->addSelect(DB::raw('YEAR(bills.created_at) as period'));
        }
        $bills = $queryBill->get()->toArray();

        $earns = [];
        $WorkShopColumn = array_column($WorkShop, 'period');
        $ServiceShopColumn = array_column($Service, 'period');
        $billsColumn = array_column($bills, 'period');
        foreach ($period as $i => $dt) {
            if ($request->period == 'day') {
                $keyWorkShop = array_search($dt->format('Y-m-d'), $WorkShopColumn);
                $keyService = array_search($dt->format('Y-m-d'), $ServiceShopColumn);
                $keyBills = array_search($dt->format('Y-m-d'), $billsColumn);
                $earns[$i]['column'] = $dt->format('j') . ' th';
            } elseif ($request->period == 'month') {
                $keyWorkShop = array_search($dt->format('Y m'), $WorkShopColumn);
                $keyService = array_search($dt->format('Y m'), $ServiceShopColumn);
                $keyBills = array_search($dt->format('Y m'), $billsColumn);
                $earns[$i]['column'] = $dt->format('M');
            } else {
                $keyWorkShop = array_search($dt->format('Y'), $WorkShopColumn);
                $keyService = array_search($dt->format('Y'), $ServiceShopColumn);
                $keyBills = array_search($dt->format('Y'), $billsColumn);
                $earns[$i]['column'] = $dt->format('Y');
            }
            $earns[$i]['earn'] = $keyWorkShop !== false ?  $WorkShop[$keyWorkShop]['earn'] : 0;
            $earns[$i]['earn'] += $keyService !== false ?  $Service[$keyService]['earn'] : 0;
            $earns[$i]['earn'] += $keyBills !== false ?  $bills[$keyBills]['earn'] : 0;
        }


        $queryService = ServiceUserOrders::query();
        $queryService->where('service_user_orders.freelancer_id',   $user->id);
        $queryService->whereIn('status', ['booked', 'freelancer_reschedule', 'user_reschedule', 'admin_reschedule', 'completed']);
        $queryService->select(DB::raw('SUM(earn) as earn'));
        $queryService->whereBetween('created_at', [date('Y-m-1 0:0:0'), date('Y-m-t 23:59:59')]);
        $Service = $queryService->first();

        $queryWorkShop = WorkshopOrder::query();
        $queryWorkShop->where('workshop_orders.freelancer_id',   $user->id);
        $queryWorkShop->where('payment_status', 'paid');
        $queryWorkShop->select(DB::raw('SUM(earn) as earn'));
        $queryWorkShop->whereBetween('created_at', [date('Y-m-1 0:0:0'), date('Y-m-t 23:59:59')]);
        $WorkShop = $queryWorkShop->first();

        $queryBill = Bill::query();
        $queryBill->where('bills.freelancer_id',   $user->id);
        $queryBill->where('payment_status', 'paid');
        $queryBill->select(DB::raw('SUM(earn) as earn'));
        $queryBill->whereBetween('created_at', [date('Y-m-1 0:0:0'), date('Y-m-t 23:59:59')]);
        $bills = $queryBill->first();
        $thisMonth = (($Service != null) ? $Service->earn : 0) + (($WorkShop != null) ? $WorkShop->earn : 0) + (($bills != null) ? $bills->earn : 0);

        return $this->apiResponse(200, ['data' => ['thisMonth' => $thisMonth, 'period' => $request->period, 'from' => $startDate, 'until' => $EndDate, 'earn' => $earns], 'message' => []]);
    }

    public function cancelService($id)
    {
        $user = Auth::user();
        $service = ServiceUserOrders::where('freelancer_id', $user->id)
            ->whereIn('status', ['booked', 'freelancer_reschedule', 'user_reschedule', 'admin_reschedule'])
            ->with(['timeSlot', 'order'])
            ->findOrfail($id);
        if (\Carbon\Carbon::now()->addHours(12)->gte(Carbon::parse($service->date . ' ' . $service->time)->format('Y-m-d H:i:s'))) {
            return $this->apiResponse(400, ['data' => [], 'message' => [trans('api.canNotCancelService')]]);
        }
        DB::beginTransaction();
        try {
            $timeSlot = $service->timeSlot;
            if ($timeSlot != null) {
                $timeSlot->status = 'free';
                $timeSlot->bookedable_id = null;
                $timeSlot->bookedable_type = null;
                $timeSlot->save();
            }
            $service->status = "freelancer_cancel";
            $service->save();
            $order = $service->order;
            $order->refund = $order->refund + $service->price;
            $order->save();
            UserNotification::add($order->user_id, $service->freelancer_id, ['cancellationWithPay', $user->name, $service->date . ' ' . $service->time], 'cancellationWithPay', ['service_id' => $service->id]);
            FreelancerNotification::add($order->user_id, $service->freelancer_id, ['cancellationServiceMySelf', $order->user->Fullname, $service->date . ' ' . $service->time], 'cancellationServiceMySelf', ['service_id' => $service->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->apiResponse(500, ['data' => [], 'message' => [$e->getMessage()]]);
        }
        DB::commit();
        return $this->apiResponse(200, ['data' => [], 'message' => [trans('api.freelancer.cancellation.serviceFromUser')]]);
    }

    public function notavailable($id)
    {
        $user = Auth::user();
        $service = ServiceUserOrders::where('freelancer_id', $user->id)
            ->whereIn('status', ['booked', 'freelancer_reschedule', 'user_reschedule', 'admin_reschedule'])
            ->with(['timeSlot', 'order'])
            ->findOrfail($id);
        if (\Carbon\Carbon::now()->addHours(12)->gte(Carbon::parse($service->date . ' ' . $service->time)->format('Y-m-d H:i:s'))) {
            return $this->apiResponse(400, ['data' => [], 'message' => [trans('api.canNotCancelService')]]);
        }
        DB::beginTransaction();
        try {
            $timeSlot = $service->timeSlot;
            if ($timeSlot != null) {
                $timeSlot->delete();
            }
            $service->status = "freelancer_not_available";
            $service->save();
            $order = $service->order;
            $order->refund = $order->refund + $service->price;
            $order->save();
            UserNotification::add($order->user_id, $service->freelancer_id, ['cancellationWithPay', $user->name, $service->date . ' ' . $service->time], 'cancellationWithPay', ['service_id' => $service->id]);
            FreelancerNotification::add($order->user_id, $service->freelancer_id, ['cancellationServiceMySelf', $order->user->Fullname, $service->date . ' ' . $service->time], 'cancellationServiceMySelf', ['service_id' => $service->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->apiResponse(500, ['data' => [], 'message' => [$e->getMessage()]]);
        }
        DB::commit();
        return $this->apiResponse(200, ['data' => [], 'message' => [trans('api.freelancer.cancellation.serviceFromUser')]]);
    }

    public function rescheduleService(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'slot_id' => 'required|exists:time_calenders,id',
        ]);
        if ($validator->fails()) {
            return $this->apiResponse(422, ['data' => [], 'message' => $validator->errors()->all()]);
        }

        $user = Auth::user();
        $service = ServiceUserOrders::where('freelancer_id', $user->id)
            ->whereIn('status', ['booked', 'freelancer_reschedule', 'user_reschedule', 'admin_reschedule'])
            ->findOrfail($id);

        if (\Carbon\Carbon::now()->addHours(12)->gte(Carbon::parse($service->date . ' ' . $service->time)->format('Y-m-d H:i:s'))) {
            return $this->apiResponse(400, ['data' => [], 'message' => [trans('api.rescheduleService12H')]]);
        }
        DB::beginTransaction();
        try {
            $lastTime = $service->timeSlot;
            $time = $user->calendar()->where('status', 'free')->findOrFail($request->slot_id);
            if (isset($lastTime)) {
                $lastTime->status = "free";
                $lastTime->bookedable_id = null;
                $lastTime->bookedable_type = null;
            }
            $time->status = "booked";
            $time->bookedable_id = $service->id;
            $time->bookedable_type = ServiceUserOrders::class;
            $time->save();
            if (isset($lastTime)) $lastTime->save();
            UserNotification::add($service->order->user_id, $service->freelancer_id, ['reschedule', $user->name, $service->date . ' ' . $service->time, [], $time->date . ' ' . $time->start_time], 'reschedule', ['service_id' => $service->id]);
            $service->status = "freelancer_reschedule";
            $service->date = $time->date;
            $service->time = $time->start_time;
            $service->save();
            DB::commit();
            return $this->apiResponse(200, ['data' => [], 'message' => [trans('api.freelancer.reschedule.service')]]);
        } catch (ModelNotFoundException $exception) {
            DB::rollBack();
            return $this->apiResponse(404, ['data' => ['model' => $exception->getModel(), 'ids' => $exception->getIds()], 'message' => [$exception->getMessage()]]);
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->apiResponse(500, ['data' => [$exception->getMessage()], 'message' => [trans('api.canNotRescheduleService')]]);
        }
    }

    public function cancelMeeting($id)
    {

        $user = Auth::user();
        $order = Meeting::where('freelancer_id', $user->id)
            ->with(['slot', 'user'])
            ->findOrfail($id);

        if (\Carbon\Carbon::now()->addHours(12)->gte(Carbon::parse($order->date . ' ' . $order->time)->format('Y-m-d H:i:s'))) {
            return $this->apiResponse(400, ['data' => [], 'message' => [trans('api.canNotSetMeeting12H')]]);
        }
        $timeSlot = $order->slot;
        if ($timeSlot != null) {
            $timeSlot->status = 'free';
            $timeSlot->bookedable_id = null;
            $timeSlot->bookedable_type = null;
            if ($timeSlot->save()) {
                $order->delete();
            }
        } else
            $order->delete();
        UserNotification::add($order->user_id, $order->freelancer_id, ['cancellationMeetingByFreelancer', $user->name, $order->date . ' ' . $order->time], 'cancellationMeetingByFreelancer', ['meeting_id' => $order->id]);
        FreelancerNotification::add($order->user_id, $order->freelancer_id, ['cancellationMeetingMySelf', $order->user->fullname, $order->date . ' ' . $order->time], 'cancellationMeetingMySelf', ['meeting_id' => $order->id]);
        return $this->apiResponse(200, ['data' => [], 'message' => [trans('api.freelancer.cancellation.meeting')]]);
    }

    public function notavailableMeeting($id)
    {
        $user = Auth::user();
        $order = Meeting::where('freelancer_id', $user->id)
            ->with(['slot', 'user'])
            ->findOrfail($id);

        if (\Carbon\Carbon::now()->addHours(12)->gte(Carbon::parse($order->date . ' ' . $order->time)->format('Y-m-d H:i:s'))) {
            return $this->apiResponse(400, ['data' => [], 'message' => [trans('api.canNotSetMeeting12H')]]);
        }
        $timeSlot = $order->slot;
        if ($timeSlot != null) {
            if ($timeSlot->delete()) {
                $order->delete();
            }
        } else
            $order->delete();
        UserNotification::add($order->user_id, $order->freelancer_id, ['cancellationMeetingByFreelancer', $user->name, $order->date . ' ' . $order->time], 'cancellationMeetingByFreelancer', ['meeting_id' => $order->id]);
        FreelancerNotification::add($order->user_id, $order->freelancer_id, ['cancellationMeetingMySelf', $order->user->fullname, $order->date . ' ' . $order->time], 'cancellationMeetingMySelf', ['meeting_id' => $order->id]);
        return $this->apiResponse(200, ['data' => [], 'message' => [trans('api.freelancer.cancellation.meeting')]]);
    }

    public function rescheduleMeeting(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'slot_id' => 'required|exists:time_calenders,id',
        ]);
        if ($validator->fails()) {
            return $this->apiResponse(422, ['data' => [], 'message' => $validator->errors()->all()]);
        }

        $user = Auth::user();
        $resource = Meeting::where('freelancer_id', $user->id)
            ->with(['slot'])
            ->findOrfail($id);
        DB::beginTransaction();
        try {
            $lastTime = $resource->slot;
            $dateOfLastOrder = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $lastTime->date . ' ' . $lastTime->start_time)->subHours(12);
            $dateOfNow = Carbon::now();
            if ($dateOfLastOrder->lte($dateOfNow)) {
                DB::rollBack();
                return $this->apiResponse(404, ['data' => [], 'message' => [trans('api.rescheduleMeeting12H')]]);
            }
            $time = $user->calendar()->where('status', 'free')->findOrFail($request->slot_id);
            $lastTime->status = "free";
            $lastTime->bookedable_id = null;
            $lastTime->bookedable_type = null;
            $time->status = "booked";
            $time->bookedable_id = $resource->id;
            $time->bookedable_type = Meeting::class;
            $time->save();
            $lastTime->save();
            UserNotification::add($resource->user_id, $resource->freelancer_id, ['reschedule', $user->name, $resource->date . ' ' . $resource->time, [], $time->date . ' ' . $time->start_time], 'reschedule', ['meeting_id' => $resource->id]);
            $resource->date = $time->date;
            $resource->time = $time->start_time;
            $resource->save();
            DB::commit();
            return $this->apiResponse(200, ['data' => [], 'message' => [trans('api.rescheduleMeeting')]]);
        } catch (ModelNotFoundException $exception) {
            DB::rollBack();
            return $this->apiResponse(404, ['data' => ['model' => $exception->getModel(), 'ids' => $exception->getIds()], 'message' => [$exception->getMessage()]]);
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->apiResponse(500, ['data' => [$exception->getMessage()], 'message' => [trans('api.canNotRescheduleMeeting')]]);
        }
    }
}
