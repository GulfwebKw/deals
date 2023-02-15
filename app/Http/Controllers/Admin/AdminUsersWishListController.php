<?php

namespace App\Http\Controllers\Admin;

use App\Freelancer;
use App\Settings;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminUsersWishListController extends Controller
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
        $this->model = '\App\Order';
        $this->title = 'WishList';
        $this->path = 'wishlist';
        $this->data['subheader1'] = 'Web Components';

        $this->data['path'] = $this->path;
        $this->data['listPermission'] = $this->path . '-list';
        $this->data['createPermission'] = $this->path . '-createe';
        $this->data['viewPermission'] = $this->path . '-view';
        $this->data['printPermission'] = $this->path . '-print';
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
    public function index($id)
    {
        $data = $this->data;
        $settings = Settings::where('keyname', 'setting')->first();
        $user = User::find($id);
        $wishlists = $user->wishlist;
        return view('gwc.users.wishlist.index', compact('wishlists', 'settings', 'data'));
    }

    public function addToWishlist(Request $request, $user_id)
    {
        $user = User::find($user_id);
        $user->wishlist()->toggle($request->id);
        return response('Successful',200);
    }
}
