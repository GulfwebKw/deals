<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\category_translation;
use App\Http\Controllers\Controller;
use App\Language;
use App\Settings;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
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
        $this->model = '\App\Category';
        $this->langs = Language::all();
        $this->title = 'Categories';
        $this->path = 'categories';
        $this->data['subheader1'] = 'Categories';

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
        $resources = $this->model::whereHas('translations', function($query) use($request) {
            
             $search = $request->query('q');
                    $query->where('id' ,$search )
                       
                        ->orWhere('title' , 'like' , '%'.$search.'%');
            
        })->orderBy('display_order', $this->settings->default_sort)->with('childrenRecursive')->where('parent_id', null)->paginate($this->settings->item_per_page_back);
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
        $resources = $this->model::with('childrenRecursive')->where('parent_id', null)->get();
        $lastOrderInfo = $this->model::OrderBy('display_order', 'desc')->first();
        if (!empty($lastOrderInfo->display_order)) {
            $lastOrder = ($lastOrderInfo->display_order + 1);
        } else {
            $lastOrder = 1;
        }
        return view('gwc.' . $this->data['path'] . '.create', [
            'data' => $this->data,
            'settings' => $this->settings,
            'resources' => $resources,
            'lastOrder' => $lastOrder,
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
            $val = array_merge($val, ['display_order' => 'required|numeric|unique:categories,display_order',]);
        $cover_image = Common::uploadImage($request, 'image', $this->path, $this->image_big_w, $this->image_big_h, $this->image_thumb_w, $this->image_thumb_h);
        $second_image = Common::uploadImage($request, 'second_image', $this->path, $this->image_big_w, $this->image_big_h, $this->image_thumb_w, $this->image_thumb_h);
        $request->validate($val);
        $category = new Category();
        $category->parent_id = $request->parent_id;
        $category->display_order = $request->display_order;
        $category->is_active = !empty($request->input('is_active')) ? '1' : '0';
        $category->slug = make_slug($request->title_en);
        $category->second_image = $second_image;
        $category->save();
        foreach ($this->langs as $lang) {
            if ($request->input('title_' . $lang->key) || $request->input('meta_desc_' . $lang->key)) {
                $translate = new category_translation();
                $translate->category_id = $category->id;
                $translate->locale = $lang->key;
                $translate->title = $request->input('title_' . $lang->key);
                $translate->meta_desc = $request->input('meta_desc_' . $lang->key);
                $translate->save();
            }
        }
        return redirect()->route('categories.index');
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
        $categories = $this->model::with('childrenRecursive')->where('parent_id', null)->get();
        $resource = Category::find($id);
        $childs = collect([]);
        $child = $resource->child;
        $childs->push($resource);
        while (!is_null($child)) {
            $childs->push($child);
            $child = $child->child;
        }
        $childrenIds = $childs->pluck('id');
        $resource = Category::find($id);

        return view('gwc.' . $this->data['path'] . '.edit', [
            'data' => $this->data,
            'settings' => $this->settings,
            'resource' => $resource,
            'langs' => $this->langs,
            'childrenIds' => $childrenIds,
            'categories' => $categories,
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
            $val = array_merge($val, ['display_order' => 'required|numeric|unique:categories,display_order,' . $id]);
        $request->validate($val);


        $category = Category::find($id);
        $cover_image = $category->image;
        if ($request->hasFile('image')) {
            $cover_image = Common::editImage($request, 'image', $this->path, $this->image_big_w, $this->image_big_h, $this->image_thumb_w, $this->image_thumb_h, $category);
            $category->image = $cover_image;
        }
        $second_image = $category->second_image;
        if ($request->hasFile('second_image')) {
            $second_image = Common::editImage($request, 'second_image', $this->path, $this->image_big_w, $this->image_big_h, $this->image_thumb_w, $this->image_thumb_h, $category);
            $category->second_image = $second_image;
        }
        $category->parent_id = $request->parent_id;
        $category->slug = make_slug($request->title_en);
        $category->is_active = !empty($request->input('is_active')) ? '1' : '0';
        $category->display_order = $request->display_order;
        $category->save();
        foreach ($this->langs as $lang) {
            $translate = category_translation::where('category_id', $category->id)->where('locale', $lang->key)->first();
            if ($translate && $request->input('title_' . $lang->key)) {
                $translate->title = $request->input('title_' . $lang->key);
                $translate->meta_desc = $request->input('meta_desc_' . $lang->key);
                $translate->save();
            } elseif (!$translate && $request->input('title_' . $lang->key)) {
                $tr = new category_translation();
                $tr->category_id = $category->id;
                $tr->locale = $lang->key;
                $tr->name = $request->input('title_' . $lang->key);
                $tr->meta_desc = $request->input('meta_desc_' . $lang->key);
                $tr->save();
            }
        }
        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::with('childrenRecursive')->where('id', $id)->first();
        $this->DeletePhotos($category->icon, $this->path . '/thumb/');
        $this->DeletePhotos($category->icon, $this->path . '/');
        if (count($category->childrenRecursive) > 0) {
            foreach ($category->childrenRecursive as $cate) {
                $this->DeletePhotos($cate->icon, $this->path . '/thumb/');
                $this->DeletePhotos($cate->icon, $this->path . '/');
            }
        }
        $category->delete();
        return redirect()->route('categories.index');
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
}
