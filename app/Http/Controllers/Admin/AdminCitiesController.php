<?php

namespace App\Http\Controllers\Admin;

use App\City;
use App\Country;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Settings;
use Auth;

class AdminCitiesController extends Controller
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
        $this->model = '\App\City';
        $this->title = 'Cities';
        $this->path = 'cities';
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
    public function index(Request $request, $id)
    {
        $this->data['url'] = '/gwc/'.$id . '/' . $this->path . '/';
        $resources = $this->model::paginate($this->settings->item_per_page_back);
        return view('gwc.' . $this->data['path'] . '.index', [
            'data' => $this->data,
            'settings' => $this->settings,
            'resources' => $resources
        ]);
    }



    /**
     * Display a listing of the city areas.
     */
    public function cityAreas($id)
    {
        $city = City::find($id);
        if($city){
            $areas = $city->areas()->paginate($this->settings->item_per_page_back);
        }

        $this->data['headTitle'] = "Areas";
        $this->data['portletTitle'] = "Areas";
        $this->data['subheader2'] = "Areas" . ' List';

        return view('gwc.' . $this->data['path'] . '.cityAreas', [
            'data' => $this->data,
            'settings' => $this->settings,
            'resources' => $areas
        ]);
    }



    /**
     * Create a new resource
     **/
    public function create($id)
    {
        $this->data['url'] = '/gwc/countries/' . $id.'/cities';
        return view('gwc.' . $this->path . '.create', [
            'data' => $this->data,
            'settings' => $this->settings,
        ]);
    }



    /**
     * Store New Resource
     **/
    public function store(Request $request, $id)
    {
        //field validation
        $this->validate($request, [
            'title_en' => 'required|string',
            'title_ar' => 'required|string',
            'lat' => 'required',
            'lng' => 'required',
        ]);

        $resource = new City();
        $resource->title_en = $request->input('title_en');
        $resource->title_ar = $request->input('title_ar');
        $resource->lat = $request->input('lat') ?? 0.0;
        $resource->lng = $request->input('lng') ?? 0.0;
        $resource->country_id = $id;
        $resource->is_active = !empty($request->input('is_active')) ? '1' : '0';
        $resource->save();


        //save logs
        $key_name = $this->title;
        $key_id = $resource->id;
        $message = "A new record is added. (" . $resource->id . ")";
        $created_by = Auth::guard('admin')->user()->id;
        Common::saveLogs($key_name, $key_id, $message, $created_by);
        //end save logs

        return redirect('/gwc/countries/'. $id . '/' . $this->path)->with('message-success', 'A record is added successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id, $city)
    {
        $this->data['url'] = '/gwc/countries/' . $id.'/cities';
        $resource = $this->model::find($city);
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
    public function update(Request $request, $id, $city)
    {
        //field validation
        $this->validate($request, [
            'title_en' => 'required|string',
            'title_ar' => 'required|string',
            'lat' => 'required',
            'lng' => 'required',
        ]);

        $resource = $this->model::find($city);
        $resource->title_en = $request->input('title_en');
        $resource->title_ar = $request->input('title_ar');
        $resource->lat = $request->input('lat') ?? 0.0;
        $resource->lng = $request->input('lng') ?? 0.0;
        $resource->country_id = $id;
        $resource->is_active = !empty($request->input('is_active')) ? '1' : '0';
        $resource->save();


        //save logs
        $key_name = $this->title;
        $key_id = $resource->id;
        $message = "Record is edited. (" . $resource->id . ")";
        $created_by = Auth::guard('admin')->user()->id;
        Common::saveLogs($key_name, $key_id, $message, $created_by);
        //end save logs

        return redirect('/gwc/countries/' . $id.'/cities')->with('message-success', 'Information is updated successfully');
    }



    /**
     * Delete the resource
     */
    public function destroy($id, $city)
    {
        if (empty($city)) {
            return redirect('/gwc/countries/'.$id . '/'. $this->path)->with('message-error', 'Param ID is missing');
        }

        $resource = $this->model::find($city);

        $areas = $resource->areas;
        if ($areas){
            foreach ($areas as $area){
                $area->delete();
            }
        }

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

    public function countryCities($id)
    {
        $this->data['url'] = '/gwc/'.$id . '/' . $this->path . '/';

        $country = Country::find($id);
        if($country){
            $cities = $country->cities()->paginate($this->settings->item_per_page_back);
        }

        $this->data['headTitle'] = "Cities";
        $this->data['portletTitle'] = "Cities";
        $this->data['subheader2'] = "Cities" . ' List';

        return view('gwc.countries.countryCities', [
            'data' => $this->data,
            'settings' => $this->settings,
            'resources' => $cities
        ]);
    }


}
