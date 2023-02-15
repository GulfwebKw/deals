<?php

namespace App\Http\Controllers\Admin;

use App\Address;
use App\Area;
use App\City;
use App\Country;
use App\Freelancer;
use App\FreelancerAddress;
use App\FreelancerHighlight;
use App\User;
use App\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class AdminFreelancerHighlightController extends Controller
{
    public $settings;
    public $model;
    public $path;
    public $title;
    public $blade;
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
        $this->model = '\App\FreelancerHighlight';
        $this->title = 'Freelancer HighLight';
        $this->path = 'highlights';
        $this->url = '/gwc/freelancer';
        $this->blade = 'freelancers.highlights';
        $this->data['subheader1'] = 'Freelancer';

        $this->data['path'] = $this->path;
        $this->data['listPermission'] = $this->path . '-list';
        $this->data['createPermission'] = $this->path . '-create';
        $this->data['editPermission'] = $this->path . '-edit';
        $this->data['deletePermission'] = $this->path . '-delete';
        $this->data['url'] = Request::capture()->path() . '/';
        $this->data['imageFolder'] = '/uploads/' . $this->path;
        $this->data['storeRoute'] = Request::capture()->path() . '/store';
        $this->data['updateRoute'] = Request::capture()->path() . '/update';
        $this->data['headTitle'] = $this->title;
        $this->data['portletTitle'] = $this->title;
        $this->data['subheader2'] = $this->title . ' List';
        $this->data['listTitle'] = 'List ' . $this->title;
        $this->data['editTitle'] = 'Edit ' . $this->title;
        $this->data['newTitle'] = 'New ' . $this->title;

    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $id)
    {
        $user = Freelancer::find($id);
        $resources = $user->highlights()->when($request->query('q')!=null , function($query) use($request) { 
                    $search = $request->query('q');
                    $query->where('id' ,$search )
                        ->orWhere('title' , 'like' , '%'.$search.'%');
                       
                })->with('images')->paginate($this->settings->item_per_page_back);
        return view('gwc.' . $this->blade . '.index', [
            'data' => $this->data,
            'settings' => $this->settings,
            'resources' => $resources
        ]);
    }
    /**
     * Create a new resource
     **/
    public function create($id)
    {

        $this->data['url'] = 'gwc/freelancers/'.$id.'/highlights';
        //$roles = Role::pluck('name', 'name')->all();
        $countries = Country::all();
        return view('gwc.' . $this->blade . '.create', [
            'data' => $this->data,
            'settings' => $this->settings,
        ]);
    }
    /**
     * Store New Resource
     **/
    public function store(Request $request, $id)
    {
        $this->validate($request, [
            "title" => "required",
            'images'=>'required',
        ]);
        foreach ((array)$request->images as $image) {
            if (File::exists(public_path('uploads/junk/' . $image))) {
                rename(public_path('uploads/junk/' . $image), public_path('uploads/highlights/' . $image));
            }
        }
        $user = Freelancer::find($id);
        DB::beginTransaction();
        try {
            $highlight = $user->highlights()->create(['title' => $request->title]);
            foreach ( $request->images as $i => $file ){
                $highlight->images()->create(['image' => '/uploads/highlights/'.$file]);
            }
            DB::commit();
            return redirect('/gwc/freelancers/' . $id . '/highlights')->with('message-success', 'Information is updated successfully');
           } catch (\Exception $e){
            DB::rollBack();
            return $this->apiResponse(500, ['data' => ['message' => [$e->getMessage()]], 'message' => ['unsuccessful']]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id, $highlight_id)
    {
        $resource = FreelancerHighlight::with('images')->find($highlight_id);
        return view('gwc.' . $this->blade . '.edit', [
            'data' => $this->data,
            'settings' => $this->settings,
            'resource' => $resource,
        ]);
    }

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
    public function update(Request $request, $id, $highlight_id)
    {
        $this->validate($request, [
            "title" => "required",
        ]);
        $highlight = FreelancerHighlight::find($highlight_id);
        if ($request->images != null and count($request->images)>0){
            foreach ((array)$request->images as $image) {
                if (File::exists(public_path('uploads/junk/' . $image))) {
                    rename(public_path('uploads/junk/' . $image), public_path('uploads/highlights/' . $image));
                    $highlight->images()->create(['image' => '/uploads/highlights/'.$image]);
    
                }
            }
        }
        //save logs
        $key_name = $this->title;
        $key_id = $highlight->id;
        $message = "Record is edited. (" . $highlight->id . ")";
        $created_by = Auth::guard('admin')->user()->id;
        Common::saveLogs($key_name, $key_id, $message, $created_by);
        //end save logs

        return redirect('/gwc/freelancers/' . $id . '/highlights')->with('message-success', 'Information is updated successfully');
    }
    /**
     * Change User password
     */
    public function destroy($freelancer_id, $id)
    {
        $resource = FreelancerHighlight::find($id);
        $images = $resource->images;
        foreach ($images as $image){
            if (File::exists(public_path('uploads/highlights/' . $image->image)))
                File::delete(public_path('uploads/highlights/' . $image->image));
        }
        $resource->delete();
                    $key_name = $this->title;
                    $key_id = $resource->id;
                    $message = "A record is removed. (" . $resource->id . ")";
                    $created_by = Auth::guard('admin')->user()->id;
                    Common::saveLogs($key_name, $key_id, $message, $created_by);
        return redirect('/gwc/freelancers/' . $freelancer_id . '/highlights')->with('message-success', 'Information is updated successfully');

    }


    /**
     * update status
     */
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
