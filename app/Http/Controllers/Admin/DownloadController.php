<?php

namespace App\Http\Controllers\Admin;

use App\FreelancerUserMessage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DownloadController extends Controller
{
    public function downloadFile($id)
    {
        $message = FreelancerUserMessage::find($id);
        $myfile = public_path(\Illuminate\Support\Str::contains($message->file, 'uploads/') ? $message->file : '/uploads/messages/'. $message->file);
        return response()->download($myfile);
    }

}
