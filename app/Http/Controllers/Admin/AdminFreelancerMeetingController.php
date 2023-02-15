<?php

namespace App\Http\Controllers\Admin;

use App\Address;
use App\Area;
use App\City;
use App\Country;
use App\DateCalender;
use App\Freelancer;
use App\Meeting;
use App\TimeCalender;
use App\User;
use App\Settings;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminFreelancerMeetingController extends Controller
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
        $this->title = 'Meetings';
        $this->path = 'meetings';
        $this->url = url();
        $this->blade = 'freelancers.meeting';
        $this->data['subheader1'] = 'Freelancer';

        $this->data['path'] = $this->path;
        $this->data['listPermission'] = $this->path . '-list';
        $this->data['createPermission'] = $this->path . '-createe';
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
        $resources = $this->model::find($id)->meetings()->whereHas('user', function($query) use($request) {
            
             $search = $request->query('q');
                    $query->where('id' ,$search )
                       
                        ->orWhere('first_name' , 'like' , '%'.$search.'%')
                        ->orWhere('last_name' , 'like' , '%'.$search.'%');
            
        })->with('user', 'slot', 'location', 'userLocation')->orderByDesc('id')->paginate($this->settings->item_per_page_back);
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
        $this->data['url'] = 'gwc/freelancer/'.$id.'/meetings';
        $freelancer = $this->model::find($id);
        $users = User::all();
        $locations = '';
            if(isset($freelancer->address))
                $locations = $freelancer->address;

        return view('gwc.' . $this->blade . '.create', [
            'data' => $this->data,
            'settings' => $this->settings,
            'locations' => $locations,
            'users' => $users,
        ]);
    }
    /**
     * Store New Resource
     **/
    public function store(Request $request, $id)
    {
        //  field validation
        $this->validate($request, [
                'user_id' => 'required|exists:users,id',
                'slot_id' => 'required|exists:time_calenders,id',
                'freelancer_location_id' => 'nullable|exists:freelancer_addresses,id',
                'user_location_id' => 'nullable|exists:addresses,id',
        ]);
        $user=Auth::user();
        DB::beginTransaction();
        try {
            $freelancer = Freelancer::findOrFail($request->freelancer_id);
            if (!$freelancer->is_active or $freelancer->offline) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Freelancer deactivate meeting!')->withInput();
            }
            if (!$freelancer->set_a_meeting) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Freelancer deactivate meeting!')->withInput();
            }

            if (
                ($request->freelancer_location_id == null and $request->user_location_id == null) or
                ($request->freelancer_location_id == null and $freelancer->location_type == "my") or
                ($request->user_location_id == null and $freelancer->location_type == "any")) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Please select location.')->withInput();
            }
            if ($request->user_location_id != null and ($freelancer->location_type == "both" or $freelancer->location_type == "any")) {
                $userAddress = $user->address()->findOrFail($request->user_location_id);
                if (!$freelancer->areas()->where('freelancer_areas.area_id', $userAddress->area_id)->exists()) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Please select location.')->withInput();
                }
            }

            $time = $freelancer->calendar()->where('status', 'free')->findOrFail($request->slot_id);

            $resource = new Meeting();
            $resource->user_id = $request->user_id;
            $resource->freelancer_id = $id ;
            $resource->time_piece_id = $time->id;
            $resource->date = $time->date;
            $resource->time = $time->start_time;
            $resource->location_id = $request->freelancer_location_id;
            $resource->area_id = $request->user_location_id;
            $resource->save();


            $time->status = "booked";
            $time->bookedable_id = $resource->id;
            $time->bookedable_type = Meeting::class ;
            $time->save();

            //save logs
            $key_name = $this->title;
            $key_id = $resource->id;
            $message = "A new record is added. (" . $resource->id . ")";
            $created_by = Auth::guard('admin')->user()->id;
            Common::saveLogs($key_name, $key_id, $message, $created_by);
            //end save logs


            DB::commit();
            return redirect('/gwc/freelancer/' . $id . '/meetings')->with('message-success', 'A record is added successfully');
        } catch(ModelNotFoundException $exception)  {
            DB::rollBack();
            return redirect()->back()->with('error', $exception->getMessage())->withInput();
        } catch ( \Exception $exception){
            DB::rollBack();
            return redirect()->back()->with('error', 'A record is added successfully')->withInput();
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id, $meeting_id)
    {
        $this->data['url'] = 'gwc/freelancer/'.$id.'/meetings';
        $freelancer = $this->model::findOrFail($id);
        $meeting  = Meeting::with('user', 'slot', 'location')->findOrFail($meeting_id);
        $locations = null;
        if ( $freelancer->location_type == "my" )
            $locations = $freelancer->address;
        if ( $freelancer->location_type == "both" ){
            $locations = $freelancer->address()->get()->toArray();
            $User = $meeting->user ;
            $userAddress = $User->address()->whereIn('area_id' , $freelancer->areas )->get()->toArray();
            $locations = array_merge($locations , $userAddress);
        }
        if ( $freelancer->location_type == "any" ){
            $User = $meeting->user ;
            $locations = $User->address()->whereIn('area_id' , $freelancer->areas )->get()->toArray();
        }
        $slots = TimeCalender::where(['freelancer_id'=> $freelancer->id, 'status' => 'free'])->get();
        return view('gwc.' . $this->blade . '.edit', [
            'data' => $this->data,
            'settings' => $this->settings,
            'locations' => $locations,
            'meeting' => $meeting,
            'slots' => $slots,
        ]);
    }

    public function update(Request $request, $freelancer_id, $id)
    {
        $this->validate($request, [
            'location' => 'required',
            'slot' => 'required',

        ]);
        $locationData = explode('_' , $request->location);
        $resource = Meeting::findOrFail($id);
        $lastTime = $resource->slot;
        $freelancer = $resource->freelancer;
        $time = $freelancer->calendar()->where('status', 'free')->findOrFail($request->slot);
        $lastTime->status = "free";
        $lastTime->bookedable_id = null;
        $lastTime->bookedable_type = null ;
        $time->status = "booked";
        $time->bookedable_id = $resource->id;
        $time->bookedable_type = Meeting::class ;
        $time->save();
        $lastTime->save();
        $resource->location_id = ($locationData[0]=="user" ? null : $locationData[1]);
        $resource->area_id = ($locationData[0]=="user" ? $locationData[1] : null);
        $resource->time_piece_id = $request->slot;
        $resource->save();

        //save logs
        $key_name = $this->title;
        $key_id = $resource->id;
        $message = "Record is edited. (" . $resource->id . ")";
        $created_by = Auth::guard('admin')->user()->id;
        Common::saveLogs($key_name, $key_id, $message, $created_by);
        //end save logs

        return redirect('/gwc/freelancer/' . $freelancer_id . '/meetings')->with('message-success', 'Information is updated successfully');
    }
    /**
     * Delete the resource
     */
    public function destroy($freelancer_id, $id)
    {

        $resource = Meeting::where('freelancer_id' , $freelancer_id )
            ->with(['slot'])
            ->findOrfail($id);
        $timeSlot = $resource->slot;
        if ( $timeSlot != null ) {
            $timeSlot->status = 'free';
            $timeSlot->bookedable_id = null;
            $timeSlot->bookedable_type = null;
            if ( $timeSlot->save() ) {
                $resource->delete();
            }
        } else
            $resource->delete();

        $key_name = $this->title;
        $key_id = $resource->id;
        $message = "A record is removed. (" . $resource->id . ")";
        $created_by = Auth::guard('admin')->user()->id;
        Common::saveLogs($key_name, $key_id, $message, $created_by);

        return redirect()->back()->with('message-success', 'Deleted successfully');
    }

}
