<?php

namespace App\Http\Controllers\Api\User;

use App\Slideshow;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SlideshowController extends Controller
{
    public function getSlideShows(Request $request)
    {
        $resources = Slideshow::where('is_active',1)->orderBy('display_order', 'Asc')->get();
        return $this->apiResponse(200, ['data' => ['slideshows' => $resources], 'message' => []]);

    }
}
