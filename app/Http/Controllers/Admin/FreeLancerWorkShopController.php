<?php

namespace App\Http\Controllers\Admin;

use App\Country;
use App\Freelancer;
use App\FreelancerServices;
use App\FreelancerWorkshop;
use App\FreelancerWorkshopTranslation;
use App\Http\Controllers\Controller;
use App\Language;
use App\Settings;
use App\WorkshopOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class FreeLancerWorkShopController extends Controller
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

        $this->model = '\App\FreelancerWorkshop';
        $this->title = 'Freelancer Workshops';
        $this->path = 'freelancer_workshops';
        $this->data['subheader1'] = 'Freelancer';

        $this->data['path'] = $this->path;
        $this->data['listPermission'] = 'freelancers' . '-list';
        $this->data['createPermission'] = 'freelancers' . '-create';
        $this->data['editPermission'] = 'freelancers' . '-edit';
        $this->data['deletePermission'] = 'freelancers' . '-delete';
        $this->data['url'] = '/gwc/freelancer/' . \Illuminate\Support\Facades\Request::segment(3) . '/workshop/';
        $this->data['imageFolder'] = '/uploads/' . $this->path;
        $this->data['storeRoute'] = 'workshop' . '.store';
        $this->data['updateRoute'] = 'workshop' . '.update';
        $this->data['headTitle'] = $this->title;
        $this->data['portletTitle'] = $this->title;
        $this->data['subheader2'] = $this->title . ' List';
        $this->data['listTitle'] =  $this->title;
        $this->data['editTitle'] =  $this->title;
        $this->data['newTitle'] = 'New ' . $this->title;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {
        $resources = Freelancer::find($id)->workshops()->whereHas('translations', function($query) use($request) {
            
             $search = $request->query('q');
                    $query->where('id' ,$search )
                       
                        ->orWhere('name' , 'like' , '%'.$search.'%');
            
        })->orderByDesc('id')->paginate($this->settings->item_per_page_back);
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
        $countries  = Country::all();
        return view('gwc.' . $this->data['path'] . '.create', [
            'data' => $this->data,
            'settings' => $this->settings,
            'langs' => $this->langs,
            'countries' => $countries
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $id)
    {
        $this->validate($request, [
            'name'=>'required',
            'date'=>'required|date',
            'from_time'=>'required',
            'to_time'=>'nullable',
            'street'=>'required',
            'block'=>'required',
            'building_name'=>'required',
            'area_id'=>'required|numeric|exists:gwc_areas,id',
            'price'=>'required|numeric',
            'total_persons'=>'required|numeric',
        ]);

        $cover_image = "";
        if ($request->hasFile('image')) {
            $cover_image = '/uploads/workshop/'.Common::uploadImage($request, 'image', 'workshop', $this->image_big_w, $this->image_big_h, $this->image_thumb_w, $this->image_thumb_h);
        }
        $request->merge([
            'is_active' => !empty($request->input('is_active')) ? '1' : '0',
            'images' =>$cover_image,
            'freelancer_id' => $id,
            'available' => $request->total_persons,
        ]);
        $workshop = FreelancerWorkshop::create($request->except('image'));

        return redirect()->route('workshop.index', $id);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($fid ,$id)
    {
        $this->data['createPermission'] = 'cannot' . '-create';
        $this->data['subheader2'] = 'Workshop booking List';
        $resources = WorkshopOrder::where('workshop_id' , $id )->with('user' )->orderByDesc('id')->paginate();
        return view('gwc.' . $this->data['path'] . '.show', [
            'data' => $this->data,
            'settings' => $this->settings,
            'resources' => $resources,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit($freelancer_id, $workshop_id)
    {
        $resource = $this->model::find($workshop_id);
        $countries  = Country::all();
        return view('gwc.freelancer_workshops.edit', [
            'data' => $this->data,
            'settings' => $this->settings,
            'resource' => $resource,
            'langs' => $this->langs,
            'countries' => $countries ,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $freelancer_id, $id)
    {
        $this->validate($request, [
            'name'=>'required',
            'date'=>'required|date',
            'from_time'=>'required',
            'to_time'=>'nullable',
            'street'=>'required',
            'block'=>'required',
            'building_name'=>'required',
            'area_id'=>'nullable|numeric|exists:gwc_areas,id',
            'price'=>'required|numeric',
            'total_persons'=>'required|numeric',
        ]);

        $workshop = $this->model::find($id);


        if ($request->hasFile('image')) {
            $cover_image = '/uploads/workshop/'.Common::editImage($request, 'image', 'workshop', $this->image_big_w, $this->image_big_h, $this->image_thumb_w, $this->image_thumb_h, $workshop);
        }

        $request->merge([
            'available' => $request->total_persons - $workshop->reserved,
            'images' => $cover_image  ?? $workshop->images ,
        ]);
        $workshop->update($request->except(['image','lastPage'] ));
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
        
        if ( $request->lastPage )
            return redirect($request->lastPage);
        return redirect()->route('workshop.index', $freelancer_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($freelancer_id, $id)
    {
        $resource = $this->model::find($id);
        if ($resource->images != null) {
            foreach (explode(',', $resource->images) as $image) {
                $this->DeletePhotos($image, 'workshop/');
                $this->DeletePhotos($image, 'workshop/thumb/');
            }
        }
        $resource->delete();
        return redirect()->route('workshop.index', $freelancer_id);
    }

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
