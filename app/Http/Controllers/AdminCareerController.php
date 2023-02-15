<?php

namespace App\Http\Controllers;

use App\Resume;
use Illuminate\Http\Request;
use App\Settings;
use Image;
use File;
use Response;
use PDF;
use Auth;

class AdminCareerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index() //Request $request
    {
        $data = [
            'headTitle' => "Careers",
            'subheader1' => 'Web Components',
            'subheader2' => 'Careers List',
            'searchUrl' => 'gwc/ourcareers',
            'listPermission' => 'career-list',
            'viewPermission' => 'career-view',
            'createPermission' => 'career-create',
            'deletePermission' => 'career-delete',
            'url' => 'gwc/career/',
            'portletTitle' => 'Careers'
        ];
        $settingInfo = Settings::where("keyname", "setting")->first();
        //check search queries
        $resumes = Resume::orderBy('id', 'DESC')->paginate($settingInfo->item_per_page_back);
        return view('gwc.career.index', ['resumes' => $resumes, 'data' => $data]);
    }

    //view
    public function view($id)
    {
        $data = [
            'headTitle' => "Careers",
            'subheader1' => 'Web Components',
            'subheader2' => 'Career view',
            'searchUrl' => 'gwc/ourcareers',
            'listTitle' => 'Careers List',
            'listPermission' => 'career-list',
            'viewPermission' => 'career-view',
            'createPermission' => 'career-create',
            'deletePermission' => 'career-delete',
            'url' => 'gwc/career/',
            'portletTitle' => 'Careers'
        ];
        $resume = Resume::find($id);
        $resume->is_read = 1;
        $resume->save();
        return view('gwc.career.view', ['resume' => $resume, 'data' => $data]);
    }

    // delete career resume
    public function destroy($id)
    {
        //check param ID
        if (empty($id)) {
            return redirect('/gwc/career')->with('message-error', 'Param ID is missing');
        }

        //get resume info
        $resume = Resume::find($id);
        //check cat id exist or not
        if (empty($resume->id)) {
            return redirect('/gwc/career')->with('message-error', 'No record found');
        }

        //delete file from folder
        if (!empty($resume->file)) {
            $web_file_path = "/uploads/resumes/" . $resume->file;
            if (File::exists(public_path($web_file_path))) {
                File::delete(public_path($web_file_path));
            }
        }

        $resume->delete();

        //save logs
        $key_name = "career";
        $key_id = $resume->id;
        $message = "Career resume is removed.(" . $resume->message . ")";
        $created_by = Auth::guard('admin')->user()->id;
        Common::saveLogs($key_name, $key_id, $message, $created_by);
        //end save logs

        return redirect()->back()->with('message-success', 'Career resume is deleted successfully');
    }

//    //list subjects
//    public function showSubjects() //
//    {
//        $settingInfo = Settings::where("keyname", "setting")->first();
//        //check search queries
//        $SubjectLists = Subjects::orderBy('id', 'DESC')->paginate($settingInfo->item_per_page_back);
//
//        $lastOrderInfo = Subjects::OrderBy('display_order', 'desc')->first();
//        if (!empty($lastOrderInfo->display_order)) {
//            $lastOrder = ($lastOrderInfo->display_order + 1);
//        } else {
//            $lastOrder = 1;
//        }
//
//        return view('gwc.contactus.subjects', ['SubjectLists' => $SubjectLists, 'lastOrder' => $lastOrder]);
//    }
//
//    //save subjects
//    public function saveSubject(Request $request)
//    {
//        //field validation
//        $this->validate($request, [
//            'title_en' => 'required|min:3|max:190|string|unique:gwc_subjects,title_en',
//            'title_ar' => 'required|min:3|max:190|string|unique:gwc_subjects,title_ar',
//        ]);
//        $subjects = new Subjects;
//        $subjects->title_en = $request->input('title_en');
//        $subjects->title_ar = $request->input('title_ar');
//        $subjects->is_active = !empty($request->input('is_active')) ? $request->input('is_active') : '0';
//        $subjects->display_order = !empty($request->input('display_order')) ? $request->input('display_order') : '0';
//        $subjects->save();
//
//        //save logs
//        $key_name = "subjects";
//        $key_id = $subjects->id;
//        $message = "A new subject is added.(" . $subjects->title_en . ")";
//        $created_by = Auth::guard('admin')->user()->id;
//        Common::saveLogs($key_name, $key_id, $message, $created_by);
//        //end save logs
//
//        return redirect('/gwc/contactus/subjects')->with('message-success', 'services is added successfully');
//    }
//
//    /**
//     * Delete services along with childs via ID.
//     *
//     * @param \Illuminate\Http\Request $request
//     * @param int $id
//     * @return \Illuminate\Http\Response
//     */
//    public function destroySubjects($id)
//    {
//        //check param ID
//        if (empty($id)) {
//            return redirect('/gwc/contactus/subjects')->with('message-error', 'Param ID is missing');
//        }
//        //get cat info
//        $subjects = Subjects::find($id);
//        //check cat id exist or not
//        if (empty($subjects->id)) {
//            return redirect('/gwc/contactus/subjects')->with('message-error', 'No record found');
//        }
//
//        //save logs
//        $key_name = "subjects";
//        $key_id = $subjects->id;
//        $message = "A subject is removed.(" . $subjects->title_en . ")";
//        $created_by = Auth::guard('admin')->user()->id;
//        Common::saveLogs($key_name, $key_id, $message, $created_by);
//        //end save logs
//
//        //end deleting parent cat image
//        $subjects->delete();
//        return redirect()->back()->with('message-success', 'Subject is deleted successfully');
//    }
//
//
//    //update status
//    public function updateStatusAjax(Request $request)
//    {
//        $recDetails = Subjects::where('id', $request->id)->first();
//        if ($recDetails['is_active'] == 1) {
//            $active = 0;
//        } else {
//            $active = 1;
//        }
//
//        //save logs
//        $key_name = "subject";
//        $key_id = $recDetails->id;
//        $message = "Subject status is changed to " . $active . ".(" . $recDetails->title_en . ")";
//        $created_by = Auth::guard('admin')->user()->id;
//        Common::saveLogs($key_name, $key_id, $message, $created_by);
//        //end save logs
//
//
//        $recDetails->is_active = $active;
//        $recDetails->save();
//        return ['status' => 200, 'message' => 'Status is modified successfully'];
//    }
//
//    //get subject name
//    public static function getSubjectName($subjectid)
//    {
//        $recDetails = Subjects::where('id', $subjectid)->first();
//        if (!empty($recDetails->title_en)) {
//            return $recDetails->title_en;
//        } else {
//            return "--";
//        }
//    }

}
