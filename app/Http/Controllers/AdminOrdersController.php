<?php

namespace App\Http\Controllers;

use App\City;
use App\Order;
use App\Transaction;
use Illuminate\Http\Request;
use App\Settings;
use Auth;
use Illuminate\Support\Facades\Cookie;

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
        $this->data['subheader1'] = 'Web Components';

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
    public function index(Request $request)
    {
        //get all orders
        $resources = $this->model::where('order_status','!=','');

        //apply date range filter
        if(!empty(Cookie::get('order_filter_dates'))){
            $explodeDates = explode("-",Cookie::get('order_filter_dates'));
            if(!empty($explodeDates[0]) && !empty($explodeDates[1])){
                $date1 = date("Y-m-d",strtotime($explodeDates[0]));
                $date2 = date("Y-m-d",strtotime($explodeDates[1]));
                $resources = $resources->whereBetween('created_at', [$date1, $date2]);
            }
        }

        //apply order status filter
        if(!empty(Cookie::get('order_filter_status')) && Cookie::get('order_filter_status')<>"all"){
            $resources = $resources->where('order_status','=',Cookie::get('order_filter_status'));
        }

        //apply payment status filter
        if(!empty(Cookie::get('pay_filter_status')) && Cookie::get('pay_filter_status')<>"all"){
            $resources = $resources->where('payment_status','=',Cookie::get('pay_filter_status'));
        }

        $resources = $resources->orderBy('id','DESC')->paginate($this->settings->item_per_page_back);

        return view('gwc.' . $this->data['path'] . '.index', [
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
        $resource = $this->model::find($id);
        if ($resource){
            $transaction = Transaction::where('trackid', $resource->order_track)->first();
            $package = $resource->package;
        }
        else{
            $resource = null;
            $transaction = null;
            $package = null;
        }

        return view('gwc.' . $this->path . '.view', [
            'data' => $this->data,
            'settings' => $this->settings,
            'resource' => $resource,
            'transaction' => $transaction,
            'package' => $package
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


}
