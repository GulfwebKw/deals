<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Settings;
use Auth;

use App\NotificationEmails;

class AdminSettingsController extends Controller
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
        $this->model = '\App\Settings';
        $this->title = 'Settings';
        $this->path = 'settings';
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
            'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'email_logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'favicon' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'seo_description_en' => 'required|string',
            'seo_description_ar' => 'required|string',
            'seo_keywords_en' => 'required|string',
            'seo_keywords_ar' => 'required|string',
            'name_en' => 'required|string',
            'name_ar' => 'required|string',
            'address_en' => 'required|string',
            'address_ar' => 'required|string',
            'email' => 'required|email',
            'mobile' => 'required|string',
            'phone' => 'required|string',
            'fax' => 'required|string',
            'from_email' => 'required|string',
            'from_name' => 'required|string',
            'social_google_plus' => 'required|string',
            'social_facebook' => 'required|string',
            'social_twitter' => 'required|string',
            'social_linkedin' => 'required|string',
            'google_analytics' => 'required|string',
            'web_server_key' => 'required|string',
        ]);

        $resource = $this->model::first();

        $logo = Common::editImage($request, 'logo', $this->path, $this->image_big_w, $this->image_big_h, $this->image_thumb_w, $this->image_thumb_h, $resource);
        $emailLogo = Common::editImage($request, 'email_logo', $this->path, $this->image_big_w, $this->image_big_h, $this->image_thumb_w, $this->image_thumb_h, $resource);
        $favicon = Common::editImage($request, 'favicon', $this->path, $this->image_big_w, $this->image_big_h, $this->image_thumb_w, $this->image_thumb_h, $resource);

        $resource->is_lang = !empty($request->input('is_lang')) ? $request->input('is_lang') : '0';
        $resource->subscribe_active_in_app = !empty($request->input('subscribe_active_in_app')) ? $request->input('subscribe_active_in_app') : '0';

        $resource->logo = $logo;
        $resource->email_logo = $emailLogo;
        $resource->favicon = $favicon;

        $resource->seo_description_en = $request->input('seo_description_en') ?? "";
        $resource->seo_description_ar = $request->input('seo_description_ar') ?? "";
        $resource->seo_keywords_en = $request->input('seo_keywords_en') ?? "";
        $resource->seo_keywords_ar = $request->input('seo_keywords_ar') ?? "";

        $resource->name_en = $request->input('name_en');
        $resource->name_ar = $request->input('name_ar');
        $resource->address_en = $request->input('address_en');
        $resource->address_ar = $request->input('address_ar');
        $resource->email = $request->input('email');
        $resource->mobile = $request->input('mobile');
        $resource->phone = $request->input('phone');
        $resource->fax = $request->input('fax');
        $resource->from_email = $request->input('from_email');
        $resource->from_name = $request->input('from_name');

        $resource->social_google_plus = $request->input('social_google_plus');
        $resource->social_facebook = $request->input('social_facebook');
        $resource->social_twitter = $request->input('social_twitter');
        $resource->social_linkedin = $request->input('social_linkedin');

        $resource->google_analytics = $request->input('google_analytics');
        $resource->web_server_key = $request->input('web_server_key');

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
