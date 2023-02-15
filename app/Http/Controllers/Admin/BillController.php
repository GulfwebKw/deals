<?php

namespace App\Http\Controllers\Admin;

use App\Freelancer;
use App\FreelancerServices;
use App\FreelancerWorkshop;
use App\FreelancerWorkshopTranslation;
use App\Http\Controllers\Controller;
use App\Language;
use App\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class BillController extends Controller
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
        $this->title = 'Bills';
        $this->path = 'bills';
        $this->data['subheader1'] = 'Bills';

        $this->data['path'] = $this->path;
        $this->data['listPermission'] = 'bills' . '-list';
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
    public function index(Request $request)
    {
        $resources = $this->model::with('freelancer', 'user')->when($request->query->count()>0 , function($query) use($request) {
    
            $user_id =  $request->query('user_id');
            $freelancer_id =  $request->query('freelancer_id');
            if ($freelancer_id)
                $query->where('freelancer_id', $freelancer_id);
            if ($user_id)
                $query->Where('user_id', $user_id);
        })->when($request->kt_daterangepicker_range , function ($query) use($request){
            $dates = explode(' - ',$request->kt_daterangepicker_range);
            $dates[0] = date('Y-m-d',strtotime($dates[0]));
            $dates[1] = date('Y-m-d',strtotime($dates[1]));
            $query->whereBetween('created_at',$dates);
        })->when($request->payment_status and $request->payment_status != "all" , function ($query) use($request){
            $query->where('payment_status',$request->payment_status);
        })->when($request->q , function ($query) use($request){
            $query->where('description','like' , '%'.$request->q.'%');
        })->when($request->id , function ($query) use($request){
            $query->where(function ($query) use($request) {
                $query->where('id',$request->id )->orWhere('uuid',$request->id );
            });
        })->orderByDesc('id')->paginate($this->settings->item_per_page_back);
        return view('gwc.' . $this->data['path'] . '.index', [
            'data' => $this->data,
            'settings' => $this->settings,
            'resources' => $resources,
        ]);
    }

}
