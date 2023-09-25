<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\category_translation;
use App\Country;
use App\Freelancer;
use App\FreelancerQuotation;
use App\FreelancerUserMessage;
use App\Http\Controllers\Controller;
use App\language;
use App\Mail\SendGrid;
use App\Meeting;
use App\Order;
use App\Quotation;
use App\Rate;
use App\ServiceUserOrders;
use App\Settings;
use App\User;
use App\WorkshopOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class FreeLancersController extends Controller
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
        $this->model = '\App\Freelancer';
        $this->title = 'Freelancers';
        $this->path = 'freelancers';
        $this->data['subheader1'] = 'Freelancers';

        $this->data['path'] = $this->path;
        $this->data['listPermission'] = $this->path . '-list';
        $this->data['viewPermission'] = $this->path . '-list';
        $this->data['createPermission'] = $this->path . '-create';
        $this->data['editPermission'] = $this->path . '-edit';
        $this->data['deletePermission'] = $this->path . '-delete';
        $this->data['approvedPermission'] = 'freelancers' . '-approved';
        $this->data['rejectPermission'] = 'freelancers' . '-reject';
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
        if ($request->query('category')!=null){
            $id = $request->query('category');
            $category = Category::where('is_active' , 1 )->findOrFail($id);
            $resources = $category->freelancers()
                ->where('freelancers.is_active' , 1 )
                ->where('freelancers.offline' , 0 )
                ->when($request->query('q')!=null , function($query) use($request) { 
                    $search = $request->query('q');
                    $query->where('id' ,$search )
                        ->orWhere('name' , 'like' , '%'.$search.'%')
                        ->orWhere('phone' , 'like' , '%'.$search.'%')
                        ->orWhere('username' , 'like' , '%'.$search.'%')
                        ->orWhere('email' , 'like' , '%'.$search.'%');
                })
                ->when($request->query('id')!=null , function($query) use($request) { 
                    $query->where('id' ,$request->query('id') );
                })->orderBy('id' , 'desc')
                ->paginate($this->settings->item_per_page_back);
        }else{
            $resources = $this->model::when($request->query('q')!=null , function($query) use($request) { 
                    $search = $request->query('q');
                    $query->where('id' ,$search )
                        ->orWhere('name' , 'like' , '%'.$search.'%')
                        ->orWhere('phone' , 'like' , '%'.$search.'%')
                        ->orWhere('username' , 'like' , '%'.$search.'%')
                        ->orWhere('email' , 'like' , '%'.$search.'%');
                })
                ->when($request->query('id')!=null , function($query) use($request) { 
                    $query->where('id' ,$request->query('id') );
                })->orderBy('id' , 'desc')->paginate($this->settings->item_per_page_back);
        }
            $categories = Category::where('parent_id', null)->with('childrenRecursive')->get();
        return view('gwc.' . $this->data['path'] . '.index', [
            'data' => $this->data,
            'settings' => $this->settings,
            'resources' => $resources,
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories  = Category::with('childrenRecursive')->where('parent_id', null)->get();
        return view('gwc.' . $this->data['path'] . '.create', [
            'data' => $this->data,
            'settings' => $this->settings,
            'categories' => $categories ,
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
        $request->validate([
            'email' => 'required|email|unique:freelancers',

        ]);
        $cover_image = Common::uploadImage($request, 'image', 'freelancer', $this->image_big_w, $this->image_big_h, $this->image_thumb_w, $this->image_thumb_h);
        $freelancer = new Freelancer();
        $freelancer->name = $request->name;
        $freelancer->email = $request->email;
        $freelancer->phone = $request->phone;
        $freelancer->link = $request->link;
        $freelancer->bio = $request->bio;

        $freelancer->service_commission_price = $request->input('service_commission_price');
        $freelancer->service_commission_percent = $request->input('service_commission_percent');
        $freelancer->service_commission_type = $request->input('service_commission_type');

        $freelancer->workshop_commission_price = $request->input('workshop_commission_price');
        $freelancer->workshop_commission_percent = $request->input('workshop_commission_percent');
        $freelancer->workshop_commission_type = $request->input('workshop_commission_type');

        $freelancer->bill_commission_price = $request->input('bill_commission_price');
        $freelancer->bill_commission_percent = $request->input('bill_commission_percent');
        $freelancer->bill_commission_type = $request->input('bill_commission_type');

        $freelancer->image = '/uploads/freelancer/'.$cover_image;
        $freelancer->is_active = !empty($request->input('is_active')) ? '1' : '0';
        $freelancer->quotation = !empty($request->input('quotation')) ? '1' : '0';
        $freelancer->set_a_meeting = !empty($request->input('set_a_meeting')) ? '1' : '0';
        // $freelancer->image = '/uploads/freelancer/'.$cover_image;
        $rate = Rate::create([
            'number_people'=>0,
            'rate'=>0,
        ]);
        $freelancer->rate_id = $rate->id;
        $freelancer->offline = $request->offline;
        $freelancer->save();

        return redirect()->route('freelancers.index');
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
        $categories = Category::where('parent_id', null)->get();
        $countries = Country::all();
        $resource = $this->model::with(['areas'=> function($q){
            $q->with(['city'=> function($qu){
                $qu->with('country');
            }]);
        }])->find($id);
        $area_ids = $resource->areas->pluck('id');
        $category_ids = $resource->categories->pluck('id');

        return view('gwc.' . $this->data['path'] . '.edit', [
            'data' => $this->data,
            'settings' => $this->settings,
            'resource' => $resource,
            'categories' => $categories,
            'countries' => $countries,
            'area_ids' => $area_ids,
            'category_ids' => $category_ids
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
        $i = 0 ;
        foreach ( $request->category_id as $idOfCategory ){
            $cat = Category::where('parent_id', null)->find($idOfCategory);
            if ( $cat != null )
                $i++;
        }
        if ( $i > 2 )
            return redirect()->back()->withInput()->withErrors(['category_id'=>'Parent category should be lower than 2 items.']);

        $resource = Freelancer::find($id);
        $cover_image = $resource->image;
        if ($request->hasFile('image'))
        $cover_image = Common::editImage($request, 'image', 'freelancer', $this->image_big_w, $this->image_big_h, $this->image_thumb_w, $this->image_thumb_h, $resource);
        $resource->name = $request->name;
        $resource->email = $request->email;
        $resource->phone = $request->phone;
        $resource->link = $request->link;
        $resource->bio = $request->bio;

        $resource->service_commission_price = $request->input('service_commission_price');
        $resource->service_commission_percent = $request->input('service_commission_percent');
        $resource->service_commission_type = $request->input('service_commission_type');

        $resource->workshop_commission_price = $request->input('workshop_commission_price');
        $resource->workshop_commission_percent = $request->input('workshop_commission_percent');
        $resource->workshop_commission_type = $request->input('workshop_commission_type');

        $resource->bill_commission_price = $request->input('bill_commission_price');
        $resource->bill_commission_percent = $request->input('bill_commission_percent');
        $resource->bill_commission_type = $request->input('bill_commission_type');

        $resource->image = $request->hasFile('image')? '/uploads/freelancer/'.$cover_image: $cover_image;
        $resource->is_active = !empty($request->input('is_active')) ? '1' : '0';
        $resource->quotation = !empty($request->input('quotation')) ? '1' : '0';
        $resource->set_a_meeting = !empty($request->input('set_a_meeting')) ? '1' : '0';
        $resource->offline = $request->offline;
        $resource->location_type = $request->location_type;
        $resource->save();
        if ( $request->area_id != null )
            $resource->areas()->sync($request->area_id);
        $resource->categories()->sync($request->category_id);
        return redirect()->route('freelancers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
       public function destroy($id)
    {
        $freelancer = $this->model::find($id);
        if ($freelancer->image && File::exists(public_path($this->path . '/thumb/'))){
        $this->DeletePhotos($freelancer->image, $this->path . '/thumb/');
            
            }
        if ($freelancer->image && File::exists(public_path($this->path . '/thumb/'))){
            $this->DeletePhotos($freelancer->image, $this->path . '/');
    }
        $freelancer->delete();
        return redirect()->route('freelancers.index');
    }

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

    public function updateOfflineStatusAjax(Request $request)
    {
        $resource = $this->model::where('id', $request->id)->first();
        if ($resource['offline'] == 1) {
            $active = 0;
        } else {
            $active = 1;
        }

        $resource->offline = $active;
        $resource->save();

            $m = collect();
        if ($active==1){
            $serviceOrder = ServiceUserOrders::where('freelancer_id' , $request->id)->whereNotIn('status' , ['freelancer_cancel','user_cancel','user_not_available','freelancer_not_available','admin_cancel','completed'])->get();
            if (count($serviceOrder)>0)
                $m->push('you have active order in services!');

            $workshop = WorkshopOrder::query()->where('freelancer_id' , $request->id)->whereHas('workshop', function ($q){
                $q->where('date', '>=', Carbon::now()->toDateString());
            })->with('workshop')->get()->map(function ($item){
                return $item->workshop;
            });
            if (count($workshop)>0)
                $m->push('you have active order in workshops!');
            $meeting = Meeting::query()->where('freelancer_id' , $request->id)
                ->where('date', '>=', Carbon::now()->toDateString())->get();
            if (count($meeting)>0)
                $m->push('you have active order in meetings!');

        }
        //save logs
        $key_name = $this->title;
        $key_id = $resource->id;
        $message = "offline is changed to " . $active . " (" . $resource->id . ")";
        $created_by = Auth::guard('admin')->user()->id;
        Common::saveLogs($key_name, $key_id, $message, $created_by);
        //end save logs

        return ['status' => 200, 'message' => 'Status is modified successfully', 'w'=>$m];
    }

    public function FreelancerMessage($id)
    {
        $this->data['listTitle'] = "Messages";
        $this->data['url'] = '/gwc/freelancers/' . $id .'/';
        //get all orders
        $resources = FreelancerUserMessage::where('freelancer_id', $id)->with('freelancer', 'user')->get()->groupBy('user_id')->map(function ($item){
            return[
                'resources'=>$item,
                'status'=>$item[count($item)-1]->status,
            ];
        });
        return view('gwc.' . $this->data['path'] . '.messages.index', [
            'data' => $this->data,
            'settings' => $this->settings,
            'resources' => $resources
        ]);
    }


    public function FreelancerQuotation($id)
    {
        $this->data['subheader2'] = "Quotations";
        $this->data['url'] = '/gwc/freelancers/' . $id .'/';
        //get all orders
        $resources = FreelancerQuotation::where('freelancer_id', $id)->with('freelancer', 'user')->get();
        return view('gwc.' . $this->data['path'] . '.quotations.index', [
            'data' => $this->data,
            'settings' => $this->settings,
            'resources' => $resources
        ]);
    }

    public function FreelancerQuotationDownload(Request $request)
    {
        if ($request->image && File::exists(public_path($request->image)))
        return response()->download(public_path($request->image));
        else
        return 'not exist';
    }


    public function FreelancerQuotationDetails($freelancer_id, $quotation_id)
    {
        //get all orders
        $resource = Quotation::where('id',$quotation_id)->with('user','freelancer','services')->first();
        return view('gwc.' . $this->data['path'] . '.quotations.view', [
            'data' => $this->data,
            'settings' => $this->settings,
            'resource' => $resource
        ]);
    }


    public function userMessages($freelancer_id, $user_id)
    {
        //get all orders
        $resources = FreelancerUserMessage::where(['user_id'=> $user_id, 'freelancer_id'=>$freelancer_id])->with('freelancer', 'user')->orderBy('id', 'DESC')->get();
        return view('gwc.' . $this->data['path'] . '.messages.view', [
            'data' => $this->data,
            'settings' => $this->settings,
            'resources' => $resources
        ]);
    }

    public function filterByCategory(Request $request)
    {
        if (!empty($request->id)) {
            $category = Category::where('is_active' , 1 )->findOrFail($request->id);
            $services = $category->freelancers()
                ->where('freelancers.is_active' , 1 )
                ->where('freelancers.offline' , 0 )
                ->paginate($this->settings->item_per_page_back);
                return response()->json([$services]);
        }
    }

    public function FreelancerPayments(Request $request, $freelancer_id)
    {
        
        $this->data['subheader2'] = "Payment Logs";
        //get all orders
        $resources = Order::when($request->query('q')!=null , function($query) use($request) { 
                    $search = $request->query('q');
                    $query->where('id' ,$search )
                        ->orWhere('order_track' , 'like' , '%'.$search.'%')
                        ->orWhere('payment_status' , 'like' , '%'.$search.'%')
                        ->orWhere('payment_id' , 'like' , '%'.$search.'%');
                })->when($request->kt_daterangepicker_range , function ($query) use($request){
                    $dates = explode(' - ',$request->kt_daterangepicker_range);
                    $dates[0] = date('Y-m-d',strtotime($dates[0]));
                    $dates[1] = date('Y-m-d',strtotime($dates[1]));
                    $query->whereBetween('created_at',$dates);
                })->when($request->payment_status and $request->payment_status != "all" , function ($query) use($request){
                    $query->where('payment_status',$request->payment_status);
                })->where('freelancer_id', $freelancer_id)->with('package')->paginate($this->settings->item_per_page_back);
        return view('gwc.' . $this->data['path'] . '.payments.index', [
            'data' => $this->data,
            'settings' => $this->settings,
            'resources' => $resources
        ]);
    }




    public function approval(Request $request)
    {
        $count = Freelancer::where('is_approved' , 'pending')->count();
        $this->title = "Pending Freelancer";
        $this->data['headTitle'] = $this->title;
        $this->data['portletTitle'] = $this->title;
        $this->data['subheader2'] = $this->title . ' List ( Pending: '.$count.' item)';
        $this->data['listTitle'] = 'List ' . $this->title;
        $resources =   Freelancer::when($request->query('q') , function($query) use($request) {
            $search =  $request->query('q');
            $query->Where('name' , 'like' , '%'.$search.'%');
        })->where('is_approved' , 'pending')->orderByDesc('id')->paginate($this->settings->item_per_page_back);

        return view('gwc.freelancers.approval', [
            'data' => $this->data,
            'settings' => $this->settings,
            'resources' => $resources,
        ]);
    }

    public function approved($id)
    {
        $resource =   Freelancer::query()->find($id);
        if ( $resource )
            $resource->update(['is_approved' => 'approved']);

        $settings = Settings::where("keyname", "setting")->first();
        $data = [
            'dear' => trans('webMessage.dear') . ' ' . $resource->name,
            'footer' => trans('webMessage.email_footer'),
            'message' => 'Your account in Deals has been successfully verified.<br>Please purchase the desired package through the website and then enter your profile and services in the application.',
            'subject' => 'Your account has been verified - Deals' ,
            'email_from' => env('MAIL_USERNAME' , $settings->from_email),
            'email_from_name' => $settings->from_name
        ];
        \Illuminate\Support\Facades\Mail::to($resource->email)->send(new SendGrid($data));
        return redirect()->back()->with('message-success', 'Freelancer approved successfully.');
    }

    public function reject($id)
    {
        $resource =   Freelancer::query()->find($id);
        if ( $resource )
            $resource->update(['is_approved' =>  'reject']);

        $settings = Settings::where("keyname", "setting")->first();
        $data = [
            'dear' => trans('webMessage.dear') . ' ' . $resource->name,
            'footer' => trans('webMessage.email_footer'),
            'message' => 'Your account has not been verified in Deals.',
            'subject' => 'Deals verification' ,
            'email_from' => env('MAIL_USERNAME' , $settings->from_email),
            'email_from_name' => $settings->from_name
        ];
        \Illuminate\Support\Facades\Mail::to($resource->email)->send(new SendGrid($data));
        return redirect()->back()->with('message-success', 'Freelancer reject successfully.');
    }


}
