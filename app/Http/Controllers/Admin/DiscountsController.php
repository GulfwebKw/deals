<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\category_translation;
use App\Discount;
use App\Freelancer;
use App\Http\Controllers\Controller;
use App\language;
use App\Package;
use App\Rate;
use App\Settings;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DiscountsController extends Controller
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

    public function __construct()
    {
        $this->settings = Settings::where("keyname", "setting")->first();
        $this->model = '\App\Discount';
        $this->title = 'Package Discounts';
        $this->path = 'discount';
        $this->data['subheader1'] = 'Discounts';

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

    public function getCode(){
        return Discount::generateRandomCode();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $resources = Discount::query()->when($request->query('q')!=null , function($query) use($request) {
            $search = $request->query('q');
            $query->where('id' ,$search )

                ->orWhere('code' , 'like' , '%'.$search.'%');
        })->paginate($this->settings->item_per_page_back);
        return view('gwc.' . $this->data['path'] . '.index', [
            'data' => $this->data,
            'settings' => $this->settings,
            'resources' => $resources,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        $resource = new Discount();
        return view('gwc.' . $this->data['path'] . '.edit', [
            'data' => $this->data,
            'settings' => $this->settings,
            'resource' => $resource,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'code' => 'required|string|unique:discounts,code',
            'count' => 'nullable|int|min:-1',
            'price' => 'nullable|int|min:0',
            'percent' => 'nullable|int|min:0|max:100',
            'valid_from' => 'nullable',
            'valid_to' => 'nullable',
            'is_active' => 'nullable',
        ]);
        Discount::query()->create([
            'code'=>$request->code,
            'used'=>0,
            'count'=>$request->get('count' , -1) == "" ? -1 : (int) $request->get('count' , 0),
            'price'=>intval($request->get('price' , 0)),
            'percent'=>intval($request->get('percent' , 0)) ,
            'valid_from'=>$request->get('valid_from'),
            'valid_to'=>$request->get('valid_to'),
            'is_active'=>!empty($request->input('is_active')) ? '1' : '0',
        ]);
        return redirect()->route($this->data['path'] . '.index');
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit($id)
    {
        $resource = Discount::query()->findOrFail($id);
        return view('gwc.' . $this->data['path'] . '.edit', [
            'data' => $this->data,
            'settings' => $this->settings,
            'resource' => $resource,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'code' => 'required|string|unique:discounts,code,' . $id,
            'count' => 'nullable|int|min:-1',
            'price' => 'nullable|int|min:0',
            'percent' => 'nullable|int|min:0|max:100',
            'valid_from' => 'nullable',
            'valid_to' => 'nullable',
            'is_active' => 'nullable',
        ]);
        Discount::query()->findOrFail($id)->update([
            'code'=>$request->code,
            'count'=>$request->get('count' , -1) == "" ? -1 : (int) $request->get('count' , 0),
            'price'=>intval($request->get('price' , 0)),
            'percent'=>intval($request->get('percent' , 0)) ,
            'valid_from'=>$request->get('valid_from'),
            'valid_to'=>$request->get('valid_to'),
            'is_active'=>!empty($request->input('is_active')) ? '1' : '0',
        ]);
        return redirect()->route($this->data['path'] . '.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        Discount::query()->findOrFail($id)->delete();
        return redirect()->route($this->data['path'] . '.index');
    }

    public function updateStatusAjax(Request $request)
    {
        /** @var Discount $resource */
        $resource = Discount::query()->where('id', $request->id)->firstOrFail();
        $resource->is_active = ! $resource->is_active;
        $resource->save();

        //save logs
        $key_name = $this->title;
        $key_id = $resource->id;
        $message = "status is changed to " . ( $resource->is_active ? 'active' : 'deactivate') . " (" . $resource->id . ")";
        $created_by = Auth::guard('admin')->user()->id;
        Common::saveLogs($key_name, $key_id, $message, $created_by);
        //end save logs

        return ['status' => 200, 'message' => 'Status is modified successfully'];
    }

}
