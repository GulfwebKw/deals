<?php

namespace App\Http\Controllers\Admin;

use App\City;
use App\FreelancerWorkshop;
use App\Http\Resources\MyMeetingResource;
use App\Http\Resources\MyServicesResource;
use App\Http\Resources\MyWorkShopsResource;
use App\Order;
use App\ServiceUserOrders;
use App\Transaction;
use App\User;
use App\UserNotification;
use App\UserOrder;
use App\WorkshopOrder;
use Carbon\Carbon;
use App\Freelancer;
use Illuminate\Http\Request;
use App\Settings;
use Auth;
use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Meeting;

class AdminOrdersController extends Controller
{
    public $settings;
    public $model;
    public $path;
    public $title;
    public $data = [];


    /**
     * constructor of the class
     */
    public function __construct()
    {
        $this->settings = Settings::where("keyname", "setting")->first();
        $this->model = '\App\Order';
        $this->title = 'Orders';
        $this->path = 'orders';
        $this->data['subheader1'] = 'Orders';

        $this->data['path'] = $this->path;
        $this->data['listPermission'] = $this->path . '-list';
        $this->data['createPermission'] = $this->path . '-create';
        $this->data['viewPermission'] = $this->path . '-view';
        $this->data['printPermission'] = $this->path . '-print';
        $this->data['editPermission'] = $this->path . '-edit';
        $this->data['deletePermission'] = $this->path . '-delete';
        $this->data['url'] = '/gwc/' . $this->path . '/';
        $this->data['imageFolder'] = '/uploads/' . $this->path;
        $this->data['storeRoute'] = $this->path . '.store';
        $this->data['updateRoute'] = $this->path . '.update';
        $this->data['headTitle'] = $this->title;
        $this->data['portletTitle'] = $this->title;
        $this->data['subheader2'] = $this->title . ' List';
        $this->data['listTitle'] = 'List ' . $this->title;
    }



    /**
     * Display a listing of the resource.
     */
    public function indexSubscription(Request $request)
    {
        $this->data['subheader2'] = 'Freelancer Subscription List';
        //get all orders
        $resources = $this->model::when($request->query('q')!=null , function($query) use($request) { 
                    $search = $request->query('q');
                    $query->where('id' ,$search )
                        ->orWhere('order_track' , 'like' , '%'.$search.'%')
                        ->orWhereHas('freelancer', function($qu) use($search){
                            $qu->where('name', 'like' , '%'.$search.'%');
                        })
                        ->orWhere('payment_status' , 'like' , '%'.$search.'%');
                })->with('package','freelancer')
            ->when($request->kt_daterangepicker_range , function ($query) use($request){
                $dates = explode(' - ',$request->kt_daterangepicker_range);
                $dates[0] = date('Y-m-d',strtotime($dates[0]));
                $dates[1] = date('Y-m-d',strtotime($dates[1]));
                $query->whereBetween('created_at',$dates);
            })->when($request->payment_status and $request->payment_status != "all" , function ($query) use($request){
                $query->where('payment_status',$request->payment_status);
            })->orderBy('id','DESC')->paginate($this->settings->item_per_page_back);

        return view('gwc.' . $this->data['path'] . '.index', [
            'data' => $this->data,
            'settings' => $this->settings,
            'resources' => $resources
        ]);
    }



    public function index(Request $request , $id)
    {
        $user = User::findOrFail($id);
        //get all orders
        $resources = $this->model::with('package','freelancer')->where('order_status','!=','');

        $queryService = ServiceUserOrders::query();
        $queryService->whereIn('order_id' , $user->serviceOrder()->get()->pluck('id')->toArray() );
        $queryService->orderByDesc('created_at' ); 
        $queryService->when($request->kt_daterangepicker_range , function ($query) use($request){
                $dates = explode(' - ',$request->kt_daterangepicker_range);
                $dates[0] = date('Y-m-d',strtotime($dates[0]));
                $dates[1] = date('Y-m-d',strtotime($dates[1]));
                $query->whereBetween('service_user_orders.date',$dates);
            });
        $queryService->leftJoin('user_orders' , 'user_orders.id' , 'order_id');
        $queryService->leftJoin('freelancers' , 'freelancers.id' , 'service_user_orders.freelancer_id');
        $queryService->Join('freelancer_services'  , function ($join) use($request){
            $join->on('freelancer_services.id' , 'service_user_orders.service_id')
                ->when($request->q , function ($query) use($request){
                    $query->where('freelancer_services.name', 'like' , '%'.$request->q.'%');
                });
        });
        $queryService->select('service_user_orders.id' , 'service_user_orders.freelancer_id' , 'freelancers.name as freelancer_name' , 'freelancer_services.name as packageName' , 'service_user_orders.created_at' ,'service_user_orders.date' ,'service_user_orders.time' , 'freelancers.email', 'freelancers.phone' , 'status', 'service_user_orders.price as amount', 'user_orders.payment_id as payment_id', 'user_orders.error as payment_status' , DB::raw('\'service\' as type') );

        $queryWorkShop = WorkshopOrder::query();
        $queryWorkShop->where('workshop_orders.user_id' ,   $user->id);
        $queryWorkShop->orderByDesc('created_at' );
        $queryWorkShop->leftJoin('freelancers' , 'freelancers.id' , 'workshop_orders.freelancer_id');
        $queryWorkShop->Join('freelancer_workshops' , function ($join) use($request){
            $join->on('freelancer_workshops.id' , 'workshop_orders.workshop_id')
            ->when($request->kt_daterangepicker_range , function ($query) use($request){
                $dates = explode(' - ',$request->kt_daterangepicker_range);
                $dates[0] = date('Y-m-d',strtotime($dates[0]));
                $dates[1] = date('Y-m-d',strtotime($dates[1]));
                $query->whereBetween('freelancer_workshops.date',$dates);
            });
        });
        $queryWorkShop->Join('freelancer_workshop_translations' , function ($join) use($request){
            $join->on('freelancer_workshop_translations.freelancer_workshop_id' , 'workshop_orders.workshop_id')
                ->where('freelancer_workshop_translations.locale' , 'en')
                ->when($request->q , function ($query) use($request){
                    $query->where('freelancer_workshop_translations.name', 'like' , '%'.$request->q.'%');
                });
        });
        $queryWorkShopLast = $queryWorkShop->select('workshop_orders.id' , 'workshop_orders.freelancer_id' , 'freelancers.name as freelancer_name' , 'freelancer_workshop_translations.name as packageName' , 'workshop_orders.created_at' ,'freelancer_workshops.date' ,'freelancer_workshops.from_time' , 'freelancers.email', 'freelancers.phone' , 'payment_status as status' , 'workshop_orders.amount as amount', 'workshop_orders.payment_id as payment_id', 'workshop_orders.error as payment_status' , DB::raw('\'workshop\' as type') );


        if ( $request->ordertype == "Workshop" )
            $resources = $queryWorkShopLast->paginate($this->settings->item_per_page_back);
        elseif ( $request->ordertype == "Service" )
            $resources = $queryService->paginate($this->settings->item_per_page_back);
        else
            $resources = $queryService->union($queryWorkShopLast)->paginate($this->settings->item_per_page_back);
            
//        dd($resources);
        return view('gwc.users.orders.index', [
            'data' => $this->data,
            'settings' => $this->settings,
            'resources' => $resources
        ]);
    }


    //store order filtration values in cookie by ajax
    public function storeValuesInCookies(Request $request)
    {
        $minutes=3600;

        //date range
        if(!empty($request->order_dates)){
            Cookie::queue('order_filter_dates', $request->order_dates, $minutes);
        }
        //order status
        if(!empty($request->order_status)){
            Cookie::queue('order_filter_status', $request->order_status, $minutes);
        }
        //pay status
        if(!empty($request->pay_status)){
            Cookie::queue('pay_filter_status', $request->pay_status, $minutes);
        }

        return ["status"=>200,"message"=>""];
    }


    //reset order filtration
    public function resetDateRange()
    {
        //orders
        Cookie::queue('order_filter_status', '', 0);
        Cookie::queue('order_filter_dates', '', 0);
        Cookie::queue('pay_filter_status', '', 0);

        return ["status"=>200,"message"=>""];
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $resource = $this->model::find($id);

        $durations = Duration::where('is_active',1)->get();

        return view('gwc.' . $this->path . '.edit', [
            'data' => $this->data,
            'settings' => $this->settings,
            'resource' => $resource,
            'durations' => $durations
        ]);
    }


    /**
     * Show the details of the resource.
     */
    public function view($id)
    {
        $resource = $this->model::with('package', 'freelancer')->whereId($id)->first();
        return view('gwc.' . $this->path . '.view', [
            'data' => $this->data,
            'settings' => $this->settings,
            'order' => $resource,
        ]);
    }


    /**
     * Update the specified resource
     */
    public function update(Request $request, $id)
    {
        //field validation
        $this->validate($request, [
            'display_order' => 'required|numeric|unique:gwc_packages,display_order,' . $id,
            'cover_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title_en' => 'required|string',
            'title_ar' => 'required|string',
            'short_details_en' => 'required|string',
            'short_details_ar' => 'required|string',
            'duration_id' => 'required',
            'price' => 'required|numeric',
        ]);

        $resource = $this->model::find($id);

        $cover_image = Common::editImage($request, 'cover_image', $this->path, $this->image_big_w, $this->image_big_h, $this->image_thumb_w, $this->image_thumb_h, $resource);

        $resource->title_en = $request->input('title_en');
        $resource->title_ar = $request->input('title_ar');
        $resource->short_details_en = $request->input('short_details_en');
        $resource->short_details_ar = $request->input('short_details_ar');
        $resource->duration_id = $request->input('duration_id');
        $resource->price = $request->input('price');
        $resource->is_active = !empty($request->input('is_active')) ? '1' : '0';
        $resource->display_order = !empty($request->input('display_order')) ? $request->input('display_order') : '0';
        $resource->cover_image = $cover_image;
        $resource->save();

        //save logs
        $key_name = $this->title;
        $key_id = $resource->id;
        $message = "Record is edited. (" . $resource->id . ")";
        $created_by = Auth::guard('admin')->user()->id;
        Common::saveLogs($key_name, $key_id, $message, $created_by);
        //end save logs

        return redirect('/gwc/' . $this->path)->with('message-success', 'Information is updated successfully');
    }


    /**
     * Delete the resource
     */
    public function destroy($id)
    {
        if (empty($id)) {
            return redirect('/gwc/'.$this->path)->with('message-error', 'Param ID is missing');
        }

        $resource = $this->model::find($id);

        $resource->delete();

        //save logs
        $key_name = $this->title;
        $key_id = $resource->id;
        $message = "A record is removed. (" . $resource->id . ")";
        $created_by = Auth::guard('admin')->user()->id;
        Common::saveLogs($key_name, $key_id, $message, $created_by);
        //end save logs

        return redirect()->back()->with('message-success', 'Deleted successfully');
    }



    /**
     * get the name of the city
     */
    public static function getCityName($id)
    {
        $city = City::find($id);
        return $city->title_en;
    }

    public function servicesOrdersDetails($id)
    {

//        $resource = UserOrder::where('id', $id)->with(['user', 'service'=>function($q){
//            $q->with('freelancer');
//        }])->first();
        $resource = UserOrder::where('id', $id)->with(['user', 'services.service.freelancer'])->first();
        return view('gwc.' . $this->data['path'] . '.serviceOrderDetails', [
            'data' => $this->data,
            'settings' => $this->settings,
            'resource' => $resource
        ]);
    }


    public function servicesOrders(Request $request)
    {
        $this->data['subheader2'] = 'Service Orders List';
        //get all orders
//        $resources = UserOrder::with('user')->where('order_status','!=','');
        $resources = UserOrder::when($request->query('q')!=null , function($query) use($request) { 
                    $search = $request->query('q');
                    $query->where('id' ,$search )
                        ->orWhere('order_track' , 'like' , '%'.$search.'%')
                        ->orWhere('payment_status' , 'like' , '%'.$search.'%')
                        ->orWhereHas('user' , function($qu) use($search){
                            $qu->where('first_name', 'like' , '%'.$search.'%')
                            ->orWhere('last_name', 'like' , '%'.$search.'%');
                        })
                        ->orWhere('payment_id' , 'like' , '%'.$search.'%');
                })->when($request->kt_daterangepicker_range , function ($query) use($request){
                    $dates = explode(' - ',$request->kt_daterangepicker_range);
                    $dates[0] = date('Y-m-d',strtotime($dates[0]));
                    $dates[1] = date('Y-m-d',strtotime($dates[1]));
                    $query->whereBetween('created_at',$dates);
                })->when($request->payment_status and $request->payment_status != "all" , function ($query) use($request){
                    $query->where('payment_status',$request->payment_status);
                })->when($request->id , function ($query) use($request){
                    $query->where('id',$request->id );
                })->with('user', 'services', 'services.freelancer');
//        $resources = UserOrder::with('user', 'services');

        $resources = $resources->when($request->query('freelancer_id') , function($qury) use($request) { 
                $qury->whereHas('services',function($query2) use($request){
                    $query2->where('freelancer_id' , $request->query('freelancer_id') );
                });
            })->when($request->query('service_id') , function($qury) use($request) { 
                $qury->whereHas('services',function($query2) use($request){
                    $query2->where('service_id' , $request->query('service_id') );
                });
            })->orderBy('id','DESC')->paginate($this->settings->item_per_page_back);
        return view('gwc.' . $this->data['path'] . '.servicesOrders', [
            'data' => $this->data,
            'settings' => $this->settings,
            'resources' => $resources
        ]);
    }

    public function workShopOrders(Request $request)
    {
        //get all orders
        $resources = WorkshopOrder::with('user', 'freelancer')->when($request->query('q') , function($query) use($request) {
    
            $search =  $request->query('q');
            $query->where(function($quer) use($search){
            $quer->whereHas('workshop.translation',function($q) use($search){
                    $q->Where('name' , 'like' , '%'.$search.'%');
            })
              ->orWhereHas('user',function($que) use($search){
               $que->Where('first_name' , 'like' , '%'.$search.'%')
               ->orWhere('last_name' , 'like' , '%'.$search.'%');
            });
            });
        })->when($request->kt_daterangepicker_range , function ($query) use($request){
            $dates = explode(' - ',$request->kt_daterangepicker_range);
            $dates[0] = date('Y-m-d',strtotime($dates[0]));
            $dates[1] = date('Y-m-d',strtotime($dates[1]));
            $query->whereBetween('created_at',$dates);
        })->when($request->payment_status and $request->payment_status != "all" , function ($query) use($request){
            $query->where('payment_status',$request->payment_status);
        })->when($request->id , function ($query) use($request){
            $query->where('id',$request->id );
        });
        $this->data['subheader2'] = 'Workshop Order List';
        $resources = $resources->orderByDesc('id')->paginate($this->settings->item_per_page_back);
        return view('gwc.workshop-order.index', [
            'data' => $this->data,
            'settings' => $this->settings,
            'resources' => $resources
        ]);
    }

    public function makeWorkShopOrders(Request $request)
    {
        //get all orders
        $resources = FreelancerWorkshop::with('freelancer')->when($request->query('q') , function($query) use($request) {

            $search = $request->query('q');
            $query->where(function ($quer) use ($search) {
                $quer->whereHas('workshop.translation', function ($q) use ($search) {
                    $q->Where('name', 'like', '%' . $search . '%');
                });
            });
        })->when($request->kt_daterangepicker_range , function ($query) use($request){
            $dates = explode(' - ',$request->kt_daterangepicker_range);
            $dates[0] = date('Y-m-d',strtotime($dates[0]));
            $dates[1] = date('Y-m-d',strtotime($dates[1]));
            $query->whereBetween('created_at',$dates);
        })->when($request->freelancer_id , function ($query) use($request){
            $query->where('freelancer_id',$request->freelancer_id );
        })->when($request->id , function ($query) use($request){
            $query->where('id',$request->id );
        });
        $this->data['subheader2'] = 'Make Workshop Order List';
        $resources = $resources->orderByDesc('id')->paginate($this->settings->item_per_page_back);
        return view('gwc.workshop-order.make-index', [
            'data' => $this->data,
            'settings' => $this->settings,
            'resources' => $resources
        ]);
    }

    public function workShopOrdersDetails($id)
    {
        $resource = WorkshopOrder::where('id', $id)->with(['user', 'service'=>function($q){
            $q->with('freelancer');
        }])->first();
        return view('gwc.workshop-order.view', [
            'data' => $this->data,
            'settings' => $this->settings,
            'resource' => $resource
        ]);
    }

    public function deals($id){
        $this->data['subheader2'] = 'User Calender';
        $this->data['subheader1'] = 'User';
        $user = User::findOrFail($id);
        $notif = new UserNotification();
        $notif->freelancer_id = 34;
        $notif->image = "book";
        $notif->description = "New <b>booking</b> from this user.";
        $notif->user_id = $user->id;
        $notif->service_id = 44;
        $notif->save();
        $data_workshops = MyWorkShopsResource::collection($user->workshops()
            ->where('payment_status' , 'paid')
            ->whereHas('workshop', function($q){
                $q->whereDate('date','>',  \Illuminate\Support\Carbon::yesterday());
            })->with(['workshop' , 'workshop.freelancer'])->get())->resolve();
        $data_service = MyServicesResource::collection(ServiceUserOrders::whereIn('order_id' , $user->serviceOrder()->get()->pluck('id')->toArray() )
            ->whereIn('status' , ['booked' , 'freelancer_reschedule' , 'user_reschedule' , 'admin_reschedule'] )
            ->whereDate('date','>',  Carbon::yesterday())
            ->with(['service' , 'timeSlot', 'service.freelancer', 'service.category', 'service.category.lan'])->get())->resolve();

        $data_Meeting = MyMeetingResource::collection($user->mettings()->whereHas('slot', function($q){
            $q->whereDate('date','>',  Carbon::yesterday());
        })->with(['freelancer','slot'])->get())->resolve();
        $datas = array_merge($data_workshops,$data_service,$data_Meeting);
        return view('gwc.users.calendar', [
            'data' => $this->data,
            'settings' => $this->settings,
            'resources' => $datas,
            'user' => $user
        ]);
    }
    
    
    
    public function book_details($type , $id){
        if ( $type == "service" ){
            $data_service = ServiceUserOrders::where('id' , $id )
                        ->with(['service' , 'service.freelancer', 'order.user' , 'freelancer_location' , 'user_location'])->first();
            if ( $data_service == null )
                abort(404);
                
            $returnData['freelancer'] = $data_service->service ? ($data_service->service->freelancer?? [] ) : [] ;
            $returnData['user'] = $data_service->order ? ($data_service->order->user ?? [] ) : [] ;
            $returnData['resource'] = $data_service->service ??  [];
            $returnData['location'] = $data_service->freelancer_location ?? $data_service->user_location ?? [];
            $returnData['location_type'] = $data_service->freelancer_location ? 'Freelancer' : ( $data_service->user_location ? 'User' : '');
            $returnData['order'] = $data_service;
            $returnData['payment'] =  $data_service->order;
            $returnData['type'] = "service";
        }elseif ( $type == "workshop" ){
            $data = WorkshopOrder::where('id' , $id )
                        ->with(['user' , 'freelancer', 'workshop', 'workshop.area.city' ])->first();
            if ( $data == null )
                abort(404);
                
            $returnData['freelancer'] = $data->freelancer ?? [] ;
            $returnData['user'] = $data->user ?? [] ;
            $returnData['resource'] = $data->workshop ??  [];
            $returnData['location'] = $data->workshop ;
            $returnData['location_type'] = 'Freelancer';
            $returnData['order'] = $data;
            $returnData['payment'] = $data;
            $returnData['type'] = "workshop";
        }elseif ( $type == "metting" ){
            $data = Meeting::where('id' , $id )
                        ->with(['user' , 'freelancer', 'location' , 'userLocation' ])->first();
            if ( $data == null )
                abort(404);
                
            $returnData['freelancer'] = $data->freelancer ?? [] ;
            $returnData['user'] = $data->user ?? [] ;
            $returnData['resource'] = [];
            $returnData['location'] = $data->location ?? $data->userLocation ?? [];
            $returnData['location_type'] = $data->location ? 'Freelancer' : ( $data->userLocation ? 'User' : '');
            $returnData['order'] = $data;
            $returnData['payment'] = [];
            $returnData['type'] = "metting";
        } else 
            abort(404);
        //dd($returnData);
        $returnData['settings'] = $this->settings;
        $returnData['data'] = $this->data;
        return view('gwc.services.booked', $returnData);
        
    }
}
