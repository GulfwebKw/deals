<?php

namespace App\Http\Controllers\Admin;

use App\Singlepage;
use Illuminate\Http\Request;
use App\Settings;
use Auth;
use App\Http\Controllers\Controller;

class AdminSinglePagesController extends Controller
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
        $this->model = '\App\Singlepage';
        $this->title = 'Single Pages';
        $this->path = 'singlepages';
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
        $this->data['editTitle'] = 'Edit ' . $this->title;
        $this->data['newTitle'] = 'New ' . $this->title;
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
     
        $resources = $this->model::when($request->query('q')!=null , function($query) use($request) { 
                    $search = $request->query('q');
                    $query->where('id' ,$search )
                        ->orWhere('title_en' , 'like' , '%'.$search.'%')
                        ->orWhere('title_ar' , 'like' , '%'.$search.'%')
                        ->orWhere('name' , 'like' , '%'.$search.'%');
                })->orderBy('display_order', $this->settings->default_sort)->paginate($this->settings->item_per_page_back);
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
   
        $lastOrderInfo = $this->model::OrderBy('display_order', 'desc')->first();
        if (!empty($lastOrderInfo->display_order)) {
            $lastOrder = ($lastOrderInfo->display_order + 1);
        } else {
            $lastOrder = 1;
        }

        return view('gwc.' . $this->path . '.create', [
            'data' => $this->data,
            'settings' => $this->settings,
            'lastOrder' => $lastOrder
        ]);
    }


    /**
     * Store New Resource
     **/
    public function store(Request $request)
    {
        //field validation
        $this->validate($request, [
            'display_order' => 'required|numeric|unique:gwc_single_pages,display_order',
            'title_en' => 'required|string',
            'title_ar' => 'required|string',
            'details_en' => 'required|string',
            'details_ar' => 'required|string',
        ]);

        //upload image
        if (isset($request->images) && count($request->images)) {
            foreach ($request->images as $image) {
                rename(public_path('/uploads/junk/' . $image), public_path('/uploads/' . $this->path . '/' . $image));
            }
        }
        $resource = new Singlepage();
        $resource->slug = Common::createSlug('Singlepage', $request->title_en);
        $resource->title_en = $request->input('title_en');
        $resource->title_ar = $request->input('title_ar');
        $resource->name = $request->input('name');
        $resource->details_en = $request->input('details_en');
        $resource->details_ar = $request->input('details_ar');
        $resource->is_active = !empty($request->input('is_active')) ? '1' : '0';
        $resource->display_order = !empty($request->input('display_order')) ? $request->input('display_order') : '0';
        $resource->images = $request->images? implode(",", $request->images):'';
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

        return view('gwc.' . $this->path . '.edit', [
            'data' => $this->data,
            'settings' => $this->settings,
            'resource' => $resource
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
            'display_order' => 'required|numeric|unique:gwc_single_pages,display_order,' . $id,
            'title_en' => 'required|string',
            'title_ar' => 'required|string',
            'details_en' => 'required|string',
            'details_ar' => 'required|string',
        ]);

        $resource = $this->model::find($id);
        if ( in_array($resource->name  , ['TermsConditions' , 'RefundPolicy' , 'PrivacyPolicy' ,'LoginHelp' ]))
            $request->merge(['name' => $resource->name]);
        $implode = $resource->images;
        if (isset($request->images) && count($request->images)>0) {
            foreach ($request->images as $image) {
                rename(public_path('uploads/junk/' . $image), public_path('uploads/' . $this->path . '/' . $image));
            }
            if (isset($resource->images)){
                $img = explode(",", $resource->images);
                $merge = array_merge($img, $request->images);
                $implode = implode(',', $merge);
            }
        }

        $resource->slug = Common::createSlug('Singlepage', $request->title_en, $id);
        $resource->title_en = $request->input('title_en');
        $resource->title_ar = $request->input('title_ar');
        $resource->name = $request->input('name');
        $resource->details_en = $request->input('details_en');
        $resource->details_ar = $request->input('details_ar');
        $resource->is_active = !empty($request->input('is_active')) ? '1' : '0';
        $resource->display_order = !empty($request->input('display_order')) ? $request->input('display_order') : '0';
        $resource->images = $implode;
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
            return redirect('/gwc/' . $this->path)->with('message-error', 'Param ID is missing');
        }

        $resource = $this->model::find($id);

        if ( in_array($resource->name  , ['TermsConditions' , 'RefundPolicy' , 'PrivacyPolicy' ,'LoginHelp' ]))
            abort(403);

        $imageFieldName = 'image';
        if ($imageFieldName) {
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


    //update status
    public function updateStatusAjax(Request $request)
    {
        $resource = $this->model::where('id', $request->id)->first();
        if ($resource['is_active'] == 1) {
            $active = 0;
        } else {
            $active = 1;
        }

        if ( in_array($resource->name  , ['TermsConditions' , 'RefundPolicy' , 'PrivacyPolicy' ,'LoginHelp' ]))
            $active = 1 ;

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
