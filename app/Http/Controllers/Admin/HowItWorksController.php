<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\category_translation;
use App\HowItWork;
use App\HowItWork_translation;
use App\Http\Controllers\Controller;
use App\Language;
use App\Settings;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class HowItWorksController extends Controller
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
        $this->model = '\App\HowItWork';
        $this->langs = Language::all();
        $this->title = 'HowItWorks';
        $this->path = 'howitworks';
        $this->data['subheader1'] = 'HowItWorks';

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
        $this->data['editTitle'] = 'Edit ' . $this->title;
        $this->data['newTitle'] = 'New ' . $this->title;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       
         $this->data['headTitle'] = "HowItWorks";
        $resources = $this->model::whereHas('translations', function($query) use($request) {
             $search = $request->query('q');
                    $query->where('id' ,$search )
                        ->orWhere('title' , 'like' , '%'.$search.'%');
        })->paginate($this->settings->item_per_page_back);
        return view('gwc.' . $this->data['path'] . '.index', [
            'data' => $this->data,
            'settings' => $this->settings,
            'resources' => $resources
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $resources = $this->model::all();
        return view('gwc.' . $this->data['path'] . '.create', [
            'data' => $this->data,
            'settings' => $this->settings,
            'resources' => $resources,
            'langs' => $this->langs
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $val = array();
        foreach ($this->langs as $key => $lang) {
            $val = array_merge($val, ['title_' . $lang->key => 'required']);
        }

        $cover_image = Common::uploadImage($request, 'image', $this->path, $this->image_big_w, $this->image_big_h, $this->image_thumb_w, $this->image_thumb_h);
        $request->validate($val);
        $resource = new HowItWork();
        $resource->image = $cover_image;
        $resource->step = $request->step;
        $resource->display_number = $request->display_number;
        $resource->save();
        foreach ($this->langs as $lang) {
            if ($request->input('sub_title_' . $lang->key) || $request->input('title_' . $lang->key) ||$request->input('meta_desc_' . $lang->key)) {
                $translate = new HowItWork_translation();
                $translate->how_it_work_id = $resource->id;
                $translate->title = $request->input('title_' . $lang->key);
                $translate->sub_title =  $request->input('sub_title_' . $lang->key);
                $translate->description = $request->input('meta_desc_' . $lang->key);
                $translate->locale = $lang->key;
                $translate->save();
            }
        }
        return redirect()->route($this->path.'.index');
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
    public function edit($id)
    {
        $resource = $this->model::find($id);
        return view('gwc.' . $this->data['path'] . '.edit', [
            'data' => $this->data,
            'settings' => $this->settings,
            'resource' => $resource,
            'langs' => $this->langs,
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
        $val = array();
        foreach ($this->langs as $key => $lang) {
            $val = array_merge($val, ['title_' . $lang->key => 'required']);
        }
        $request->validate($val);
        $resource = HowItWork::find($id);
        $cover_image = $resource->image;
        if (isset($request->image)){
        $cover_image = Common::uploadImage($request, 'image', $this->path, $this->image_big_w, $this->image_big_h, $this->image_thumb_w, $this->image_thumb_h);
        }
        $resource->step = $request->step;
        $resource->display_number = $request->display_number;
        $resource->image = $cover_image;
        $resource->save();
        foreach ($this->langs as $lang) {
            if ($request->input('sub_title_' . $lang->key) || $request->input('title_' . $lang->key) ||$request->input('meta_desc_' . $lang->key)) {
                $translate = HowItWork_translation::where('how_it_work_id', $resource->id)->where('locale', $lang->key)->first();
                $translate->title = $request->input('title_' . $lang->key);
                $translate->sub_title =  $request->input('sub_title_' . $lang->key);
                $translate->description = $request->input('meta_desc_' . $lang->key);
                $translate->locale = $lang->key;
                $translate->save();
            }
        }
        return redirect()->route($this->path.'.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $H = HowItWork::find($id);
        $this->DeletePhotos($H->image, $this->path . '/thumb/');
        $this->DeletePhotos($H->image, $this->path . '/');
        
        $H->delete();
        return redirect()->route($this->path.'.index');
    }
}
