<?php

namespace App\Http\Controllers;

use App\Area;
use App\City;
use App\Country;
use App\User;
use App\Settings;
use Illuminate\Http\Request;
use Auth;

use DB;
use File;
use Hash;
use Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class AdminUsersController extends Controller
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
        $this->model = '\App\User';
        $this->title = 'Users';
        $this->path = 'users';
        $this->data['subheader1'] = 'System';

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
        //$roles = Role::pluck('name', 'name')->all();
        $countries = Country::all();

        return view('gwc.' . $this->path . '.create', [
            'data' => $this->data,
            'settings' => $this->settings,
            'countries' => $countries
            //'roles' => $roles,
        ]);
    }


    /**
     * Store New Resource
     **/
    public function store(Request $request)
    {
        //field validation
        $this->validate($request, [
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'first_name' => 'required|string|min:3|max:255',
            'last_name' => 'required|string|min:3|max:255',
            'email' => 'required|email|unique:gwc_users|max:255',
            'country_code' => 'required|numeric',
            'mobile' => 'required|numeric',
            'birthday' => 'required|string',
            'country' => 'required',
            'city' => 'required',
            'area' => 'required',
            'block' => 'required|string',
            'street' => 'required|string',
            'avenue' => 'required|string',
            'house_no' => 'required|string',
            'flat' => 'required|string',
            'username' => 'required|string|unique:gwc_users|min:3|max:255',
            'password' => 'required|string|min:3',
        ]);

        //upload image
        $image = Common::uploadImage($request, 'image', $this->path, $this->image_big_w, $this->image_big_h, $this->image_thumb_w, $this->image_thumb_h);

        $resource = new User();
        $resource->first_name = $request->input('first_name');
        $resource->last_name = $request->input('last_name');
        $resource->email = $request->input('email');
        $resource->country_code = $request->input('country_code');
        $resource->mobile = $request->input('mobile');
        $resource->birthday = $request->input('birthday');
        $resource->gender = $request->input('gender');
        $resource->country_id = $request->input('country');
        $resource->city_id = $request->input('city');
        $resource->area_id = $request->input('area');
        $resource->block = $request->input('block');
        $resource->street = $request->input('street');
        $resource->avenue = $request->input('avenue');
        $resource->house_no = $request->input('house_no');
        $resource->flat = $request->input('flat');
        $resource->username = $request->input('username');
        $resource->password = bcrypt($request->input('password'));
        $resource->is_active = !empty($request->input('is_active')) ? '1' : '0';
        $resource->newsletter = !empty($request->input('newsletter')) ? '1' : '0';
        $resource->image = $image;
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

        //$roles = Role::pluck('name', 'name')->all();
        //$userRoles = $resource->roles->pluck('name', 'name')->all();

        $countries = Country::all();
        $countryId = $resource->country_id;
        $country = Country::find($countryId);

        $cities = $country->cities;
        $cityId = $resource->city_id;
        $city = City::find($cityId);

        $areas = $city->areas;
        $areaId = $resource->area_id;
        $area = Area::find($areaId);

        return view('gwc.' . $this->path . '.edit', [
            'data' => $this->data,
            'settings' => $this->settings,
            'resource' => $resource,
            'id' => $id,
            'countries' => $countries,
            'cities' => $cities,
            'areas' => $areas,
            //'roles' => $roles,
            //'userRoles' => $userRoles
        ]);
    }


    /**
     * Show the form for editing the password.
     */
    public function changePass($id)
    {
        $resource = $this->model::find($id);

        //$roles = Role::pluck('name', 'name')->all();
        //$userRoles = $resource->roles->pluck('name', 'name')->all();

        return view('gwc.' . $this->path . '.edit', [
            'data' => $this->data,
            'settings' => $this->settings,
            'resource' => $resource,
            'id' => $id,
            //'roles' => $roles,
            //'userRoles' => $userRoles
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
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'first_name' => 'required|string|min:3|max:255',
            'last_name' => 'required|string|min:3|max:255',
            'email' => 'required|email|unique:gwc_users,email,' . $id,
            'country_code' => 'required|numeric',
            'mobile' => 'required|numeric',
            'birthday' => 'required|string',
            'country' => 'required',
            'city' => 'required',
            'area' => 'required',
            'block' => 'required|string',
            'street' => 'required|string',
            'avenue' => 'required|string',
            'house_no' => 'required|string',
            'flat' => 'required|string',
        ]);

        $resource = $this->model::find($id);

        $image = Common::editImage($request, 'image', $this->path, $this->image_big_w, $this->image_big_h, $this->image_thumb_w, $this->image_thumb_h, $resource);

        $resource->first_name = $request->input('first_name');
        $resource->last_name = $request->input('last_name');
        $resource->email = $request->input('email');
        $resource->country_code = $request->input('country_code');
        $resource->mobile = $request->input('mobile');
        $resource->birthday = $request->input('birthday');
        $resource->gender = $request->input('gender');
        $resource->country_id = $request->input('country');
        $resource->city_id = $request->input('city');
        $resource->area_id = $request->input('area');
        $resource->block = $request->input('block');
        $resource->street = $request->input('street');
        $resource->avenue = $request->input('avenue');
        $resource->house_no = $request->input('house_no');
        $resource->flat = $request->input('flat');
        $resource->image = $image;
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
     * Change User password
     */
    public function userChangePass(Request $request, $id)
    {
        //field validation
        $this->validate($request, [
            'current_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required|same:new_password',
        ]);

        $resource = User::find($id);

        if (Hash::check($request->current_password, $resource->password)) {
            $resource->password = bcrypt($request->new_password);
            $resource->save();

            //save logs
            $key_name = $this->path;
            $key_id = $resource->id;
            $message = "Password is changed for " . $resource['name'];
            $created_by = Auth::guard('admin')->user()->id;
            Common::saveLogs($key_name, $key_id, $message, $created_by);

            return redirect()->back()->with('message-success', 'Information is updated successfully');
        }
        else {
            $error = array('current_password' => 'Please enter correct current password');
            return redirect()->back()->withErrors($error)->withInput();
        }
    }


    /**
     * Delete the Image.
     */
    public function deleteImage($id, $field)
    {
        $resource = $this->model::find($id);

        Common::deleteImage($field, $this->path, $resource);

        //save logs
        $key_name = $this->title;
        $key_id = $resource->id;
        $message = "Image is removed. (" . $resource->id . ")";
        $created_by = Auth::guard('admin')->user()->id;
        Common::saveLogs($key_name, $key_id, $message, $created_by);
        //end save logs

        return redirect()->back()->with('message-success', 'Image is deleted successfully');
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

        $imageFieldName = 'image';
        if($imageFieldName){
            if (!empty($resource->$imageFieldName)) {
                Common::deleteImage($imageFieldName, $this->path, $resource);
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


    /**
     * update newsletter
     */
    public function updateNewsletterAjax(Request $request)
    {
        $resource = $this->model::where('id', $request->id)->first();
        if ($resource['newsletter'] == 1) {
            $active = 0;
        } else {
            $active = 1;
        }

        $resource->newsletter = $active;
        $resource->save();

        //save logs
        $key_name = $this->title;
        $key_id = $resource->id;
        $message = "newsletter status is changed to " . $active . " (" . $resource->id . ")";
        $created_by = Auth::guard('admin')->user()->id;
        Common::saveLogs($key_name, $key_id, $message, $created_by);
        //end save logs

        return ['status' => 200, 'message' => 'Newsletter Status is modified successfully'];
    }



    //////////////////////////////// AJAX ///////////////////////////////////////////



    // get list of cities according to country id
    public function getCountryCities(Request $request)
    {
        if (! empty($request->country_id)){
            $countryId = $request->country_id;
            $country = Country::find($countryId);
            if ($country){
                $cities = $country->cities;
                $response = "<option value='' >Select City</option>";
                foreach ($cities as $city){
                    $response .= "<option value='" . $city->id . "'>" . $city->title_en . "</option>";
                }
                return response()->json([$response]);
            }
        }
    }


    // get list of areas according to city id
    public function getCityAreas(Request $request)
    {
        if (! empty($request->city_id)){
            $cityId = $request->city_id;
            $city = City::find($cityId);
            if ($city){
                $areas = $city->areas;
                $response = "<option value='' >Select Area</option>";
                foreach ($areas as $area){
                    $response .= "<option value='" . $area->id . "'>" . $area->title_en . "</option>";
                }
                return response()->json([$response]);
            }
        }
    }

}
