<?php

namespace App\Http\Controllers\Admin;

use App\Attr_group;
use App\Attribute;
use App\Category;
use App\Http\Controllers\Controller;
use App\Language;
use App\Settings;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AttributeGroupController extends Controller
{

    public $settings;
    public $model;
    public $path;
    public $title;
    public $data = [];
    public $langs = [];


    public function __construct()
    {
        $this->settings = Settings::where("keyname", "setting")->first();
        $this->model = '\App\Attr_group';
        $this->title = 'Attribute Groups';
        $this->langs = Language::all();
        $this->path = 'attribute-groups';
        $this->data['subheader1'] = 'Attribute Groups';

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
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $resources = $this->model::paginate($this->settings->item_per_page_back);
        return view('gwc.' . $this->data['path'] . '.index', [
            'data' => $this->data,
            'settings' => $this->settings,
            'langs' => $this->langs,
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
        $resources = Attribute::all();
        return view('gwc.' . $this->data['path'] . '.create', [
            'data' => $this->data,
            'settings' => $this->settings,
            'langs' => $this->langs,
            'resources' => $resources
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
        $attrs = collect();
        foreach ($request->attr as $atr){
            if (Attribute::find($atr))
                $attrs->push(json_decode(Attribute::find($atr)->value));
        }
        $attr = new Attr_group();
        $attr->name = $request->name;
        $attr->value = json_encode($attrs);
        $attr->save();
        return redirect()->route('attribute-groups.index');

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

        $value = collect();
        foreach (json_decode($resource->value, true) as $v){
            $value->push($v['en']) ;
        }
        $attributes = Attribute::all();
        return view('gwc.' . $this->data['path'] . '.edit', [
            'data' => $this->data,
            'settings' => $this->settings,
            'resource' => $resource,
            'value' => $value->toArray(),
            'attributes' => $attributes,
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
        $value =  collect();
        foreach ($request->attr as $v){

            $value->push(json_decode($v));
        }
        $this->model::find($id)->update(['value' => json_encode($value), 'name'=>$request->name]);
        //        $attrs = collect();
//        foreach ($request->attr as $atr){
//            if (Attribute::find($atr))
//                $attrs->push(Attribute::find($atr)->title);
//        }
//        $attr = Attr_group::find($id);
//        $attr->name = $request->name;
//        $attr->value = json_encode($attrs);
//        $attr->save();
        return redirect()->route('attribute-groups.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $attribute = $this->model::find($id);
        $attribute->delete();
            return redirect()->route('attribute-groups.index');
    }
}
