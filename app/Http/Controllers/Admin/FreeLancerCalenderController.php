<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\category_translation;
use App\DateCalender;
use App\Freelancer;
use App\FreelancerServices;
use App\Http\Controllers\Controller;
use App\language;
use App\Rate;
use App\Settings;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class FreeLancerCalenderController extends Controller
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

    public function __construct()
    {
        $this->settings = Settings::where("keyname", "setting")->first();
        $this->model = '\App\DateCalender';
        $this->title = 'freelancer Calender';
        $this->path = 'freelancer_calenders';
        $this->data['subheader1'] = 'Freelancers';

        $this->data['path'] = $this->path;
        $this->data['listPermission'] = 'freelancers' . '-list';
        $this->data['createPermission'] = 'freelancers' . '-create';
        $this->data['editPermission'] = 'freelancers' . '-edit';
        $this->data['deletePermission'] = 'freelancers' . '-delete';
        $this->data['url'] = '/gwc/freelancer/' .\Illuminate\Support\Facades\Request::segment(3) .'/calenders/';
        $this->data['imageFolder'] = '/uploads/' . $this->path;
        $this->data['storeRoute'] = 'calenders' . '.store';
        $this->data['updateRoute'] = 'calenders' . '.update';
        $this->data['headTitle'] = $this->title;
        $this->data['portletTitle'] = $this->title;
        $this->data['subheader2'] = $this->title . ' List';
        $this->data['listTitle'] = 'List ' . $this->title;
        $this->data['editTitle'] = 'Edit ' . $this->title;
        $this->data['newTitle'] = 'New ' . $this->title;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $resources = Freelancer::find($id);
        $resources = $resources->calenders??[];
        return view('gwc.' . $this->data['path'] . '.index', [
            'data' => $this->data,
            'settings' => $this->settings,
            'resources' => $resources,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('gwc.' . $this->data['path'] . '.create', [
            'data' => $this->data,
            'settings' => $this->settings,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        dd($request->all());
        DateCalender::create([
            'freelancer_id' => $id,
            'name' => $request->name,
            'price' => $request->price,
            'short_desc' => $request->short_desc,
            'images' => implode(",", $request->images),
            'is_active' => !empty($request->is_active) ? '1' : '0',
            'highlight' => !empty($request->highlight) ? '1' : '0',
        ]);
        return redirect()->route('calenders.index', $id);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($freelancer_id, $service_id)
    {
        $resource = $this->model::find($service_id);
        return view('gwc.freelancer_calenders.edit', [
            'data' => $this->data,
            'settings' => $this->settings,
            'resource' => $resource,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $freelancer_id, $id)
    {
        $services =  FreelancerServices::find($id);
        $cover_image = $services->image;
        if ($request->images && count($request->images)) {
            foreach ($request->images as $image) {
                rename(public_path('uploads/junk/' . $image), public_path('uploads/' . $this->path . '/' . $image));
            }
            if ($services->images!=null){
            $images = array_merge($request->images, explode(',', $services->images));
            }else{
            $images = $request->images;
            }
        $services->images = implode(",", $images);
            $services->save();
        }
            if ($request->hasFile('image')) {
                $cover_image = Common::editImage($request, 'image', $this->path, $this->image_big_w, $this->image_big_h, $this->image_thumb_w, $this->image_thumb_h, $services);
            }
            $services->update([
            'name' => $request->name,
            'price' => $request->price,
            'short_desc' => $request->short_desc,
            'image' => $cover_image,
             'highlight' => !empty($request->highlight) ? '1' : '0',
             'is_active' => !empty($request->is_active) ? '1' : '0',
        ]);
        return redirect()->route('calenders.index', $freelancer_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($freelancer_id, $id)
    {
        $resource = $this->model::find($id);
        if ($resource->images != null) {
            foreach (explode(',', $resource->images) as $image) {
                $this->DeletePhotos($image, $this->path . '/');
                $this->DeletePhotos($image, $this->path . '/thumb/');
            }
        }
        $resource->delete();
        return redirect()->route('calenders.index', $freelancer_id);
    }

    public function updateStatusAjax(Request $request)
    {
        $recDetails = DateCalender::where('id',$request->id)->first();
        if($recDetails['is_active']==1){
            $active=0;
        }else{
            $active=1;
        }


        $key_name   = "Free lancer service";
        $key_id     = $recDetails->id;
        $message    = "Free lancer service status is changed";
        $created_by = Auth::guard('admin')->user()->id;
        Common::saveLogs($key_name,$key_id,$message,$created_by);



        $recDetails->is_active=$active;
        $recDetails->save();
        return ['status'=>200,'message'=>'Status is modified successfully'];
    }
    public function updateHighlightAjax(Request $request)
    {
        $highlightRec = DateCalender::where('id',$request->id)->first();
        if($highlightRec['highlight']==1){
            $highlight=0;
        }else{
            $highlight=1;
        }


        $key_name   = "Free lancer service";
        $key_id     = $highlightRec->id;
        $message    = "highlight is changed";
        $created_by = Auth::guard('admin')->user()->id;
        Common::saveLogs($key_name,$key_id,$message,$created_by);



        $highlightRec->highlight=$highlight;
        $highlightRec->save();
        return ['status'=>200,'message'=>'Highlight is modified successfully'];
    }
}
