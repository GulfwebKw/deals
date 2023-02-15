<?php

namespace App\Http\Controllers;

use App\Admin;
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

class AdminAdminsController extends Controller
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
        $this->model = '\App\Admin';
        $this->title = 'Admins';
        $this->path = 'admins';
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
        $roles = Role::pluck('name', 'name')->all();

        return view('gwc.' . $this->path . '.create', [
            'data' => $this->data,
            'settings' => $this->settings,
            'roles' => $roles
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
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email|unique:gwc_admins|max:255',
            'mobile' => 'required|numeric|digits:8',
            'username' => 'required|string|unique:gwc_admins|min:3|max:255',
            'password' => 'required|string|min:3',
            'roles' => 'required'
        ]);

        //upload image
        $image = Common::uploadImage($request, 'image', $this->path, $this->image_big_w, $this->image_big_h, $this->image_thumb_w, $this->image_thumb_h);

        $resource = new Admin();
        $resource->name = $request->input('name');
        $resource->email = $request->input('email');
        $resource->mobile = $request->input('mobile');
        $resource->username = $request->input('username');
        $resource->password = bcrypt($request->input('password'));
        $resource->is_active = !empty($request->input('is_active')) ? '1' : '0';
        $resource->image = $image;
        $resource->save();

        //assign roles
        $resource->assignRole($request->input('roles'));

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
        $roles = Role::pluck('name', 'name')->all();
        $userRoles = $resource->roles->pluck('name', 'name')->all();

        return view('gwc.' . $this->path . '.edit', [
            'data' => $this->data,
            'settings' => $this->settings,
            'resource' => $resource,
            'id' => $id,
            'roles' => $roles,
            'userRoles' => $userRoles
        ]);
    }


    /**
     * Show the form for editing the password.
     */
    public function changePass($id)
    {
        $resource = $this->model::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRoles = $resource->roles->pluck('name', 'name')->all();

        return view('gwc.' . $this->path . '.edit', [
            'data' => $this->data,
            'settings' => $this->settings,
            'resource' => $resource,
            'id' => $id,
            'roles' => $roles,
            'userRoles' => $userRoles
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
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email|unique:gwc_admins,email,' . $id,
            'mobile' => 'required|numeric|digits:8',
            'roles' => 'required'
        ]);

        $resource = $this->model::find($id);

        $image = Common::editImage($request, 'image', $this->path, $this->image_big_w, $this->image_big_h, $this->image_thumb_w, $this->image_thumb_h, $resource);

        $resource->name = $request->input('name');
        $resource->email = $request->input('email');
        $resource->mobile = $request->input('mobile');
        $resource->image = $image;
        $resource->save();

        $roles = $request->roles;
        $resource->syncRoles($roles);

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
     * Change Admin password
     */
    public function adminChangePass(Request $request, $id)
    {
        //field validation
        $this->validate($request, [
            'current_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required|same:new_password',
        ]);

        $resource = Admin::find($id);

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

}
