<?php

namespace App\Http\Controllers;

use App\Admin;
use Illuminate\Http\Request;
use App\Settings;
use Auth;

use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminRolesController extends Controller
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
        $this->model = 'Spatie\Permission\Models\Role';
        $this->title = 'Roles';
        $this->path = 'roles';
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
        $permissionGroups = DB::table('permission_groups')->orderBy('display_order')->get();
        $groups = [];
        foreach ($permissionGroups as $permissionGroup){
            $permissions = Permission::where('group_id',$permissionGroup->id)->get();
            $groups[] = [
                'name' => $permissionGroup->title,
                'display_order' => $permissionGroup->display_order,
                'permissions' => $permissions
            ];
        }

        return view('gwc.' . $this->path . '.create', [
            'data' => $this->data,
            'settings' => $this->settings,
            'groups' => $groups,
        ]);
    }



    /**
     * Store New Resource
     **/
    public function store(Request $request)
    {
        //field validation
        $this->validate($request, [
            'name' => 'required|string',
        ]);

        $resource = new Role();
        $resource->name = $request->input('name');
        $resource->guard_name = 'admin';
        $resource->save();

        $resource->syncPermissions($request->input('permissions'));

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

        $rolePermissions = DB::table("role_has_permissions")
            ->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();

        $permissionGroups = DB::table('permission_groups')->orderBy('display_order')->get();
        $groups = [];
        foreach ($permissionGroups as $permissionGroup){
            $permissions = Permission::where('group_id',$permissionGroup->id)->get();
            $groups[] = [
                'name' => $permissionGroup->title,
                'display_order' => $permissionGroup->display_order,
                'permissions' => $permissions
            ];
        }

        return view('gwc.' . $this->path . '.edit', [
            'data' => $this->data,
            'settings' => $this->settings,
            'resource' => $resource,
            'groups' => $groups,
            'rolePermissions' => $rolePermissions
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
            'name' => 'required|string',
        ]);

        $resource = $this->model::find($id);
        $resource->name = $request->input('name');
        $resource->save();

        $resource->syncPermissions($request->input('permissions'));

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
     * Delete the resource
     */
    public function destroy($id)
    {
        if (empty($id)) {
            return redirect('/gwc/'.$this->path)->with('message-error', 'Param ID is missing');
        }

        $resource = $this->model::find($id);

        // remove this role from all users having this role
        $admins = Admin::role($resource)->get();
        foreach ($admins as $admin){
            $admin->removeRole($resource);
        }

        //remove all permissions from this role
        $resource->syncPermissions([]);

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

}
