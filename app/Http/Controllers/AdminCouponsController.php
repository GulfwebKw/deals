<?php

namespace App\Http\Controllers;

use App\Coupon;
use Illuminate\Http\Request;
use App\Settings;
use Auth;

class AdminCouponsController extends Controller
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
        $this->model = '\App\Coupon';
        $this->title = 'Coupons';
        $this->path = 'coupons';
        $this->data['subheader1'] = 'Web Components';

        $this->data['path'] = $this->path;
        $this->data['listPermission'] = $this->path . '-list';
        $this->data['createPermission'] = $this->path . '-create';
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
        $resources = $this->model::paginate($this->settings->item_per_page_back);
        return view('gwc.' . $this->data['path'] . '.index', [
            'data' => $this->data,
            'settings' => $this->settings,
            'resources' => $resources
        ]);
    }



    /**
     * Create a new resource
     **/
    public function create()
    {
        return view('gwc.' . $this->path . '.create', [
            'data' => $this->data,
            'settings' => $this->settings,
        ]);
    }



    /**
     * Store New Resource
     **/
    public function store(Request $request)
    {
        //field validation
        $this->validate($request, [
            'title_en' => 'required|string|unique:gwc_coupons,title_en',
            'title_ar' => 'required|string|unique:gwc_coupons,title_ar',
            'coupon_code' => 'required|string|unique:gwc_coupons,coupon_code',
            'coupon_type' => 'required',
            'coupon_value' => 'required|numeric',
            'date_start' => 'required|date',
            'date_end' => 'required|date|after:date_start',
            'price_start' => 'required|numeric',
            'price_end' => 'required|numeric|gt:price_start',
            'usage_limit' => 'required|integer'
        ]);

        $resource = new Coupon();
        $resource->title_en = $request->input('title_en');
        $resource->title_ar = $request->input('title_ar');
        $resource->coupon_code = $request->input('coupon_code');
        $resource->coupon_type = $request->input('coupon_type');
        $resource->coupon_value = $request->input('coupon_value');
        $resource->date_start = $request->input('date_start');
        $resource->date_end = $request->input('date_end');
        $resource->price_start = $request->input('price_start');
        $resource->price_end = $request->input('price_end');
        $resource->usage_limit = $request->input('usage_limit');
        $resource->is_for = $request->input('is_for');
        $resource->is_free = !empty($request->input('is_free')) ? '1' : '0';
        $resource->is_active = !empty($request->input('is_active')) ? '1' : '0';
        $resource->save();

        //save logs
        $key_name = $this->title;
        $key_id = $resource->id;
        $message = "A new record is added. (" . $resource->id . ")";
        $created_by = Auth::guard('admin')->user()->id;
        Common::saveLogs($key_name, $key_id, $message, $created_by);
        //end save logs

        return redirect('/gwc/' . $this->path)->with('message-success', 'A record is added successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $resource = $this->model::find($id);

        return view('gwc.' . $this->path . '.edit', [
            'data' => $this->data,
            'settings' => $this->settings,
            'resource' => $resource,
        ]);
    }


    /**
     * Show the details of the resource.
     */
    public function view($id)
    {
        $resource = $this->model::find($id);
        return view('gwc.' . $this->path . '.view', [
            'data' => $this->data,
            'settings' => $this->settings,
            'resource' => $resource
        ]);
    }


    /**
     * Update the specified resource
     */
    public function update(Request $request, $id)
    {
        //field validation
        $this->validate($request, [
            'title_en' => 'required|string|unique:gwc_coupons,title_en,' . $id,
            'title_ar' => 'required|string|unique:gwc_coupons,title_ar,' . $id,
            'coupon_code' => 'required|string|unique:gwc_coupons,coupon_code,' . $id,
            'coupon_type' => 'required',
            'coupon_value' => 'required|numeric',
            'date_start' => 'required|date',
            'date_end' => 'required|date|after:date_start',
            'price_start' => 'required|numeric',
            'price_end' => 'required|numeric|gt:price_start',
            'usage_limit' => 'required|integer'
        ]);

        $resource = $this->model::find($id);

        $resource->title_en = $request->input('title_en');
        $resource->title_ar = $request->input('title_ar');
        $resource->coupon_code = $request->input('coupon_code');
        $resource->coupon_type = $request->input('coupon_type');
        $resource->coupon_value = $request->input('coupon_value');
        $resource->date_start = $request->input('date_start');
        $resource->date_end = $request->input('date_end');
        $resource->price_start = $request->input('price_start');
        $resource->price_end = $request->input('price_end');
        $resource->usage_limit = $request->input('usage_limit');
        $resource->is_for = $request->input('is_for');
        $resource->is_free = !empty($request->input('is_free')) ? '1' : '0';
        $resource->is_active = !empty($request->input('is_active')) ? '1' : '0';
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



    //update status
    public function updateStatusAjax(Request $request)
    {
        $resource = $this->model::where('id', $request->id)->first();
        if ($resource['is_active'] == 1) {
            $active = 0;
        } else {
            $active = 1;
        }

        $resource->is_active = $active;
        $resource->save();

        //save logs
        $key_name = $this->title;
        $key_id = $resource->id;
        $message = "status is changed to " . $active . " (" . $resource->id . ")";
        $created_by = Auth::guard('admin')->user()->id;
        Common::saveLogs($key_name, $key_id, $message, $created_by);
        //end save logs

        return ['status' => 200, 'message' => 'Status is modified successfully'];
    }

}
