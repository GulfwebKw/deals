<?php

namespace App\Http\Controllers\Admin;

use App\Freelancer;
use App\FreelancerServices;
use App\FreelancerWorkshop;
use App\FreelancerWorkshopTranslation;
use App\Http\Controllers\Controller;
use App\Language;
use App\ServiceUserOrders;
use App\Settings;
use App\WorkshopOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use function foo\func;

class BookedController extends Controller
{

    public $settings;
    public $model;
    public $path;
    public $title;
    public $data = [];
    public $langs = [];

    public $image_big_w = 0;
    public $image_big_h = 0;
    public $image_thumb_w = 128;
    public $image_thumb_h = 128;

    public function __construct()
    {
        $this->settings = Settings::where("keyname", "setting")->first();
        $this->langs = Language::all();

        $this->model = '\App\Bill';
        $this->title = 'Booked';
        $this->path = 'Booked';
        $this->data['subheader1'] = 'Booked';

        $this->data['path'] = $this->path;
        $this->data['listPermission'] = 'workshops' . '-list';
        $this->data['createPermission'] = 'workshops' . '-create';
        $this->data['editPermission'] = 'workshops' . '-edit';
        $this->data['deletePermission'] = 'workshops' . '-delete';
        $this->data['url'] = '/gwc/workshops/';
        $this->data['imageFolder'] = '/uploads/freelancer_workshops';
        $this->data['storeRoute'] = 'workshops' . '.store';
        $this->data['updateRoute'] = 'workshops' . '.update';
        $this->data['headTitle'] = $this->title;
        $this->data['portletTitle'] = $this->title;
        $this->data['subheader2'] = $this->title . ' List';
        $this->data['listTitle'] = 'List ' . $this->title;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function servicesList(Request $request)
    {
        $this->data['path'] = $this->path;
        $this->data['listPermission'] = 'orders-list';
        $this->data['headTitle'] = 'Booked Service';
        $this->data['portletTitle'] = 'Booked Service';
        $this->data['subheader2'] = 'Booked Service List';
        $this->data['listTitle'] = 'List Booked Service';

        $resources = ServiceUserOrders::with('freelancer', 'order', 'order.user', 'service')->when($request->query->count()>0 , function($query) use($request) {
            $user_id =  $request->query('user_id');
            $freelancer_id =  $request->query('freelancer_id');
            if ($freelancer_id)
                $query->where('freelancer_id', $freelancer_id);
            if ($user_id)
                $query->WhereHas('order', function ($query) use($user_id) {
                        $query->where('user_id' , $user_id);
                });
        })->when($request->kt_daterangepicker_range , function ($query) use($request){
            $dates = explode(' - ',$request->kt_daterangepicker_range);
            $dates[0] = date('Y-m-d',strtotime($dates[0]));
            $dates[1] = date('Y-m-d',strtotime($dates[1]));
            $query->where(function ($query) use($dates) {
                $query->whereBetween('created_at',$dates)
                    ->orWhereBetween('date' , $dates);
            });
        })->when($request->status and $request->status != "all" , function ($query) use($request){
            $query->where('status','like' , '%'.$request->status.'%');
        })->when($request->q , function ($query) use($request){
            //$query->where('description','like' , '%'.$request->q.'%');
        })->when($request->id , function ($query) use($request){
            $query->where('id',$request->id );
        })->orderByDesc('id')->paginate($this->settings->item_per_page_back);
        return view('gwc.booked.services', [
            'data' => $this->data,
            'settings' => $this->settings,
            'resources' => $resources,
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function workshopsList(Request $request)
    {
        $this->data['path'] = $this->path;
        $this->data['listPermission'] = 'orders-list';
        $this->data['headTitle'] = 'Booked Workshops';
        $this->data['portletTitle'] = 'Booked Workshops';
        $this->data['subheader2'] = 'Booked Workshops List';
        $this->data['listTitle'] = 'List Booked Workshops';

        $resources = WorkshopOrder::with('user', 'freelancer', 'workshop', 'workshop.translations')->when($request->query->count()>0 , function($query) use($request) {
            $user_id =  $request->query('user_id');
            $freelancer_id =  $request->query('freelancer_id');
            if ($freelancer_id)
                $query->where('freelancer_id', $freelancer_id);
            if ($user_id)
                $query->where('user_id', $user_id);
        })->when($request->kt_daterangepicker_range , function ($query) use($request){
            $dates = explode(' - ',$request->kt_daterangepicker_range);
            $dates[0] = date('Y-m-d',strtotime($dates[0]));
            $dates[1] = date('Y-m-d',strtotime($dates[1]));
            $query->whereBetween('created_at',$dates);
        })->when($request->payment_status and $request->payment_status != "all" , function ($query) use($request){
            $query->where('payment_status',$request->payment_status);
        })->when($request->q , function ($query) use($request){
            //$query->where('description','like' , '%'.$request->q.'%');
        })->when($request->id , function ($query) use($request){
            $query->where('id',$request->id );
        })->orderByDesc('id')->paginate($this->settings->item_per_page_back);
        return view('gwc.booked.workshops', [
            'data' => $this->data,
            'settings' => $this->settings,
            'resources' => $resources,
        ]);
    }

}
