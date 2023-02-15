<?php

namespace App\Http\Controllers\Admin;

use App\Sms;
use Illuminate\Http\Request;
use App\Settings;
use Auth;
use App\Http\Controllers\Controller;

class AdminSmsController extends Controller
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
        $this->model = '\App\Sms';
        $this->title = 'SMS';
        $this->path = 'sms';
        $this->data['subheader1'] = 'System';

        $this->data['path'] = $this->path;
        $this->data['editPermission'] = $this->path . '-edit';
        $this->data['url'] = '/gwc/' . $this->path . '/';
        $this->data['imageFolder'] = '/uploads/' . $this->path;
        $this->data['updateRoute'] = $this->path . '.update';
        $this->data['headTitle'] = $this->title;
    }



    /**
     * Display a form to edit data
     */
    public function index(Request $request)
    {
        $resource = $this->model::first();
        return view('gwc.' . $this->path . '.form', [
            'data' => $this->data,
            'settings' => $this->settings,
            'resource' => $resource,
        ]);
    }



    /**
     * Update the specified resource
     */
    public function update(Request $request)
    {
        //field validation
        $this->validate($request, [
            'user_id' => 'required|numeric',
            'sender_name' => 'required|string',
            'api_key' => 'required|string',
            'cod_en' => 'required|string',
            'cod_ar' => 'required|string',
            'knet_en' => 'required|string',
            'knet_ar' => 'required|string',
            'track_order_en' => 'required|string',
            'track_order_ar' => 'required|string',
            'outofstock_en' => 'required|string',
            'outofstock_ar' => 'required|string',
        ]);

        $resource = $this->model::first();

        $resource->user_id = $request->input('user_id');
        $resource->sender_name = $request->input('sender_name');
        $resource->api_key = $request->input('api_key');
        $resource->is_active = !empty($request->input('is_active')) ? '1' : '0';

        $resource->cod_en = $request->input('cod_en');
        $resource->cod_ar = $request->input('cod_ar');
        $resource->cod_active = !empty($request->input('cod_active')) ? '1' : '0';

        $resource->knet_en = $request->input('knet_en');
        $resource->knet_ar = $request->input('knet_ar');
        $resource->knet_active = !empty($request->input('knet_active')) ? '1' : '0';

        $resource->track_order_en = $request->input('track_order_en');
        $resource->track_order_ar = $request->input('track_order_ar');
        $resource->track_order_active = !empty($request->input('track_order_active')) ? '1' : '0';

        $resource->outofstock_en = $request->input('outofstock_en');
        $resource->outofstock_ar = $request->input('outofstock_ar');
        $resource->outofstock_active = !empty($request->input('outofstock_active')) ? '1' : '0';

        $resource->save();

        //save logs
        $key_name   = $this->title;
        $key_id     = $resource->id;
        $message    = "information updated";
        $created_by = Auth::guard('admin')->user()->id;
        Common::saveLogs($key_name,$key_id,$message,$created_by);
        //end save logs

        return redirect('/gwc/' . $this->path)->with('message-success','Information updated successfully');
    }

}
