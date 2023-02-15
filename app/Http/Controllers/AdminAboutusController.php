<?php

namespace App\Http\Controllers;

use App\Aboutus;
use Illuminate\Http\Request;
use App\Settings;
use Auth;

class AdminAboutusController extends Controller
{
    public $settings;
    public $model;
    public $path;
    public $title;
    public $data = [];

    public $image_big_w = 0;
    public $image_big_h = 0;
    public $image_thumb_w = 128;
    public $image_thumb_h = 128;


    /**
     * constructor of the class
     */
    public function __construct()
    {
        $this->settings = Settings::where("keyname", "setting")->first();
        $this->model = '\App\Aboutus';
        $this->title = 'Aboutus';
        $this->path = 'aboutus';
        $this->data['subheader1'] = 'Pages';

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
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'details_en' => 'required|string',
            'details_ar' => 'required|string',
        ]);

        $resource = $this->model::first();

        $image = Common::editImage($request, 'image', $this->path, $this->image_big_w, $this->image_big_h, $this->image_thumb_w, $this->image_thumb_h, $resource);

        $resource->details_en = $request->input('details_en');
        $resource->details_ar = $request->input('details_ar');
        $resource->image = $image;
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



    /**
     * Delete the Image.
     */
    public function deleteImage($field)
    {
        $resource = $this->model::first();

        Common::deleteImage($field, $this->path, $resource);

        //save logs
        $key_name = $this->title;
        $key_id = $resource->id;
        $message = "Image is removed";
        $created_by = Auth::guard('admin')->user()->id;
        Common::saveLogs($key_name, $key_id, $message, $created_by);
        //end save logs

        return redirect()->back()->with('message-success', 'Image is deleted successfully');
    }

}
