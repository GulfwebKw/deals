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

class ServiceController extends Controller
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

        $this->model = '\App\FreelancerServices';
        $this->title = 'freelancer Services';
        $this->path = 'services';
        $this->data['subheader1'] = 'Services';

        $this->data['path'] = $this->path;
        $this->data['listPermission'] = 'services' . '-list';
        $this->data['createPermission'] = 'services' . '-create';
        $this->data['editPermission'] = 'services' . '-edit';
        $this->data['deletePermission'] = 'services' . '-delete';
        $this->data['url'] = '/gwc/services/';
        $this->data['imageFolder'] = '/uploads/freelancer_services';
        $this->data['storeRoute'] = 'services' . '.store';
        $this->data['updateRoute'] = 'services' . '.update';
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
        $resources = $this->model::with('freelancer', 'category')->when($request->query('q') , function($query) use($request) {
    
            $search =  $request->query('q');
            $query->where(function($quer) use($search){
            $quer->whereHas('freelancer',function($q) use($search){
                    $q->Where('name' , 'like' , '%'.$search.'%');
            })
              ->orWhereHas('category.translation',function($que) use($search){
               $que->Where('title' , 'like' , '%'.$search.'%');
            });
            })
            ->orWhere('name' , 'like' , '%'.$search.'%');
        })->orderByDesc('id')->paginate($this->settings->item_per_page_back);
        return view('gwc.' . $this->data['path'] . '.index', [
            'data' => $this->data,
            'settings' => $this->settings,
            'resources' => $resources,
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $resource = $this->model::find($id);
        return view('gwc.services.edit', [
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
    public function update(Request $request, $id)
    {
        dd('this part is not working please go to freelancers workshop and edited');
        $workshop =  $this->model::find($id);
        if ($request->images && count($request->images)) {
            foreach ($request->images as $image) {
                rename(public_path('uploads/junk/' . $image), public_path('uploads/' . $this->path . '/' . $image));
            }
            $images = array_merge($request->images, explode(',', $workshop->images));
            $workshop->images = implode(",", $images);
            $workshop->save();
        }
        $workshop->update([
            'time' => $request->time,
            'date' => $request->date,
            'is_active' => !empty($request->input('is_active')) ? '1' : '0',
            'price' => $request->price,
            'total_persons' => $request->total_persons,
            'lat' => explode(',', $request->location)[0],
            'long' => explode(',', $request->location)[1],
        ]);
        foreach ($this->langs as $lang) {
            $translate = FreelancerWorkshopTranslation::where('freelancer_workshop_id', $workshop->id)->where('locale', $lang->key)->first();
            if ($translate && $request->input('name_' . $lang->key)) {
                $translate->name = $request->input('name_' . $lang->key);
                $translate->description = $request->input('desc_' . $lang->key);
                $translate->save();
            } elseif (!$translate && $request->input('name_' . $lang->key)) {
                $tr = new FreelancerWorkshopTranslation();
                $tr->freelancer_workshop_id = $workshop->id;
                $tr->locale = $lang->key;
                $tr->name = $request->input('name_' . $lang->key);
                $tr->description = $request->input('desc_' . $lang->key);
                $tr->save();
            }
        }
        return redirect('/gwc/workshops');
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
        return redirect()->route('services.index', $freelancer_id);
    }

    public function changeHighlightStatus(Request $request)
    {
        $resource = $this->model::where('id', $request->id)->first();
        if ($resource['highlight'] == 1) {
            $highlight = 0;
        } else {
            $highlight = 1;
        }

        $resource->highlight = $highlight;
        $resource->save();

        //save logs
        $key_name = $this->title;
        $key_id = $resource->id;
        $message = "status is changed to " . $highlight . " (" . $resource->id . ")";
        $created_by = Auth::guard('admin')->user()->id;
        Common::saveLogs($key_name, $key_id, $message, $created_by);
        //end save logs

        return ['status' => 200, 'message' => 'Status is modified successfully'];
    }

    public function changeActiveStatus(Request $request)
    {
        $resource = $this->model::where('id', $request->id)->first();
        if ($resource['is_active'] == 1) {
            $is_active = 0;
        } else {
            $is_active = 1;
        }

        $resource->is_active = $is_active;
        $resource->save();

        //save logs
        $key_name = $this->title;
        $key_id = $resource->id;
        $message = "status is changed to " . $is_active . " (" . $resource->id . ")";
        $created_by = Auth::guard('admin')->user()->id;
        Common::saveLogs($key_name, $key_id, $message, $created_by);
        //end save logs

        return ['status' => 200, 'message' => 'Status is modified successfully'];
    }

    public function details($id)
    {
      $resource =   FreelancerWorkshop::whereId($id)->with('freelancer')->first();

        return view('gwc.workshops.view', [
            'data' => $this->data,
            'settings' => $this->settings,
            'resource' => $resource,
        ]);
    }

}
