<?php

namespace App\Http\Controllers\Admin;

use App\Address;
use App\Area;
use App\City;
use App\Country;
use App\FreelancerAddress;
use App\User;
use App\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AdminFreelancerAddressController extends Controller
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
        $this->model = '\App\Freelancer';
        $this->title = 'Freelancer Address';
        $this->path = 'address';
        $this->url = url();
        $this->blade = 'freelancers.address';
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
        $resources = $this->model::find($id)->address()->when($request->query('q')!=null , function($query) use($request) { 
                    $search = $request->query('q');
                    $query->where('id' ,$search )
                        ->orWhere('full_name' , 'like' , '%'.$search.'%')
                        ->orWhere('country' , 'like' , '%'.$search.'%')
                        ->orWhere('city' , 'like' , '%'.$search.'%');
                })->paginate($this->settings->item_per_page_back);
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

        $this->data['url'] = 'gwc/freelancers/'.$id.'/address';
        //$roles = Role::pluck('name', 'name')->all();
        $countries = Country::all();
        return view('gwc.' . $this->blade . '.create', [
            'data' => $this->data,
            'settings' => $this->settings,
            'countries' => $countries,
            //'roles' => $roles,
        ]);
    }
    /**
     * Store New Resource
     **/
    public function store(Request $request, $id)
    {
        //field validation
        $this->validate($request, [
            'full_name' => 'required',
            'country_id' => 'required|numeric',

        ]);
        $country = Country::find($request->country_id);
        $city = City::find($request->city_id);
        $area = Area::find($request->area_id);
        $resource = new FreelancerAddress();
        $resource->freelancer_id = $id;
        $resource->full_name = $request->input('full_name');
        $resource->block = $request->input('block');
        $resource->street = $request->input('street');
        $resource->avenue = $request->input('avenue');
        $resource->house_apartment = $request->input('house_apartment');
        $resource->floor = $request->input('floor');
        $resource->country = $country->title_en;
        $resource->country_id = $country->id;
        $resource->city = $city->title_en;
        $resource->city_id = $city->id;
        $resource->area = $area->title_en;
        $resource->area_id = $area->id;
        $resource->lat = explode(',', $request->location)[0];
        $resource->lng = explode(',', $request->location)[1];
        $resource->save();

        //save logs
        $key_name = $this->title;
        $key_id = $resource->id;
        $message = "A new record is added. (" . $resource->id . ")";
        $created_by = Auth::guard('admin')->user()->id;
        Common::saveLogs($key_name, $key_id, $message, $created_by);
        //end save logs

        return redirect('/gwc/freelancers/' . $id . '/address')->with('message-success', 'A record is added successfully');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id, $address_id)
    {
        $this->data['url'] = 'gwc/freelancers/'.$id.'/address';
        $countries = Country::all();
        $address = FreelancerAddress::find($address_id);
        return view('gwc.' . $this->blade . '.edit', [
            'data' => $this->data,
            'settings' => $this->settings,
            'resource' => $address,
            'id' => $id,
            'countries' => $countries,
        ]);
    }

    public function address($id)
    {
        $resource = $this->model::find($id);
        $addresses = FreelancerAddress::where('freelancer_id', $id)->get();
        return view('gwc.' . $this->path . '.edit', [
            'data' => $this->data,
            'settings' => $this->settings,
            'resource' => $resource,
            'addresses' => $addresses,
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
    public function update(Request $request, $user_id, $id)
    {
        //field validation
        $this->validate($request, [
            'full_name' => 'required',
            'country_id' => 'required|numeric',
            'city_id' => 'required',
        ]);
        $country = Country::find($request->country_id);
        $city = City::find($request->city_id);
        $area = Area::find($request->area_id);
        $resource = FreelancerAddress::find($id);
        $resource->full_name = $request->input('full_name');
        $resource->block = $request->input('block');
        $resource->street = $request->input('street');
        $resource->avenue = $request->input('avenue');
        $resource->house_apartment = $request->input('house_apartment');
        $resource->floor = $request->input('floor');
        $resource->country = $country->title_en;
        $resource->country_id = $country->id;
        $resource->city = $city->title_en;
        $resource->city_id = $city->id;
        $resource->area = $area->title_en;
        $resource->area_id = $area->id;
        $resource->lat = explode(',', $request->location)[0];
        $resource->lng = explode(',', $request->location)[1];
        $resource->save();

        //save logs
        $key_name = $this->title;
        $key_id = $resource->id;
        $message = "Record is edited. (" . $resource->id . ")";
        $created_by = Auth::guard('admin')->user()->id;
        Common::saveLogs($key_name, $key_id, $message, $created_by);
        //end save logs

        return redirect('/gwc/freelancers/' . $user_id . '/address')->with('message-success', 'Information is updated successfully');
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
        } else {
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
    public function destroy($freelancer_id, $address_id)
    {
        if (empty($freelancer_id || $address_id)) {
            return redirect('/gwc/' . $this->path)->with('message-error', 'Param ID is missing');
        }

        $resource = FreelancerAddress::find($address_id);
        $resource->delete();
                    $key_name = $this->title;
                    $key_id = $resource->id;
                    $message = "A record is removed. (" . $resource->id . ")";
                    $created_by = Auth::guard('admin')->user()->id;
                    Common::saveLogs($key_name, $key_id, $message, $created_by);
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
        if (!empty($request->country_id)) {
            $countryId = $request->country_id;
            $country = Country::find($countryId);
            if ($country) {
                $cities = $country->cities;
                $response = "<option value='' >Select City</option>";
                foreach ($cities as $city) {
                    $response .= "<option value='" . $city->id . "'>" . $city->title_en . "</option>";
                }
                return response()->json([$response]);
            }
        }
    }


    // get list of areas according to city id
    public function getCityAreas(Request $request)
    {
        if (!empty($request->city_id)) {
            $cityId = $request->city_id;
            $city = City::find($cityId);
            if ($city) {
                $areas = $city->areas;
                $response = "<option value='' >Select Area</option>";
                foreach ($areas as $area) {
                    $response .= "<option value='" . $area->id . "'>" . $area->title_en . "</option>";
                }
                return response()->json([$response]);
            }
        }
    }

}
