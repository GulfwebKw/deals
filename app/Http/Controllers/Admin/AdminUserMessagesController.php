<?php

namespace App\Http\Controllers\Admin;

use App\City;
use App\FreelancerUserMessage;
use App\ReportMessage;
use Illuminate\Http\Request;
use App\Settings;
use Auth;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\Controller;

class AdminUserMessagesController extends Controller
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
        $this->model = '\App\FreelancerUserMessage';
        $this->title = 'User Messages';
        $this->path = 'messages';
        $this->data['subheader1'] = 'Web Components';

        $this->data['path'] = $this->path;
        $this->data['listPermission'] = $this->path . '-list';
        $this->data['createPermission'] = $this->path . '-create';
        $this->data['viewPermission'] = $this->path . '-view';
        $this->data['printPermission'] = $this->path . '-print';
        $this->data['editPermission'] = $this->path . '-edit';
        $this->data['deletePermission'] = $this->path . '-delete';
        $this->data['url'] = '/gwc/users/' . $this->path . '/';
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
        
        $this->data['url'] = '/gwc/users/' . $id .'/';
        //get all orders
        $resources = FreelancerUserMessage::where('user_id', $id)->when($request->query('search')!=null , function($query) use($request) { 
            $query->whereHas('freelancer', function($query) use($request) {
            
             $search = $request->query('search');
                    $query->where('id' ,$search )
                       
                        ->orWhere('name' , 'like' , '%'.$search.'%');
            
        }); })->with('freelancer', 'user')->get()->groupBy('freelancer.name')->map(function ($item){
            return[
                'resources'=>$item,
                'status'=>$item[count($item)-1]->status,
            ];
        });
        return view('gwc.users.' . $this->data['path'] . '.index', [
            'data' => $this->data,
            'settings' => $this->settings,
            'resources' => $resources
        ]);
    }

    public function reportedMessage(Request $request){
        $this->data['subheader1'] = 'Contact us';
        $this->data['headTitle'] = 'Reported message';
        $this->data['portletTitle'] = 'Reported message';
        $this->data['subheader2'] = 'Reported Message List';
        $this->data['listTitle'] = 'List Reported Message';
        $resources = ReportMessage::with('user' , 'freelancer')
            ->orderBy('status')
            ->orderByDesc('id')
            ->paginate($this->settings->item_per_page_back);
        return view('gwc.messages.reported', [
            'data' => $this->data,
            'settings' => $this->settings,
            'resources' => $resources
        ]);
    }
    public function reportedMessageChecked(Request $request , $id){
        $resources = ReportMessage::findOrFail($id);
        $resources->status = 1 ;
        $resources->save();
        return redirect()->back()->with('message-success', 'Successfully marked as checked.');

    }

    public function userMessages($user_id, $freelancer_id)
    {
        //get all orders
        $resources = $this->model::where(['user_id'=> $user_id, 'freelancer_id'=>$freelancer_id])->with('freelancer', 'user')->orderBy('id', 'DESC')->get();
        return view('gwc.users.' . $this->data['path'] . '.view', [
            'data' => $this->data,
            'settings' => $this->settings,
            'resources' => $resources
        ]);
    }
}
