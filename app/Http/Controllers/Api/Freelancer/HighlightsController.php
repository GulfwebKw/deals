<?php

namespace App\Http\Controllers\Api\Freelancer;

use App\Http\Controllers\Admin\Common;
use App\Settings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class HighlightsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $user = Auth::user();
        $highlights = $user->highlights()->orderByDesc('id')->with('images')->get();
        return $this->apiResponse(200, ['data' => ['highlights' => $highlights], 'message' => []]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            "title" => "required",
            'file'=>'required|array|max:'.Settings::getOne('highlightNum' , 5 ),
            'file.*'=>'file|mimes:jpg,png,jpeg,gif,svg',
        ]);

        $user = Auth::user();
        DB::beginTransaction();
        try {
            $highlight = $user->highlights()->create(['title' => $request->title]);
            foreach ( $request->file as $i => $file ){
                $cover_image = Common::uploadImage($request, 'file.'.$i , 'highlights', 0, 0, 0, 0);
                $highlight->images()->create(['image' => '/uploads/highlights/'.$cover_image]);
            }
            DB::commit();
            return $this->apiResponse(200, ['data' => [], 'message' => []]);
        } catch (\Exception $e){
            DB::rollBack();
            return $this->apiResponse(500, ['data' => ['message' => [$e->getMessage()]], 'message' => [trans('api.unknownError')]]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $user = Auth::user();
        $highlight = $user->highlights()->with('images')->findOrFail($id);
        return $this->apiResponse(200, ['data' => ['highlight' => $highlight], 'message' => []]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            "title" => "required",
            'file'=>'required|array|max:'.Settings::getOne('highlightNum' , 5 ),
            'file.*'=>'file|image',
        ]);

        $user = Auth::user();
        DB::beginTransaction();
        try {
            $highlight = $user->highlights()->findOrFail($id);
            $highlight->update(['title' => $request->title]);
            $this->deleteImage($highlight);
            $highlight->images()->delete();
            foreach ( $request->file as $i => $file ){
                $cover_image = Common::uploadImage($request, 'file.'.$i , 'highlights', 0, 0, 0, 0);
                $highlight->images()->create(['image' => '/uploads/highlights/'.$cover_image]);
            }
            DB::commit();
            return $this->apiResponse(200, ['data' => [], 'message' => []]);
        } catch (\Exception $e){
            DB::rollBack();
            return $this->apiResponse(500, ['data' => ['message' => [$e->getMessage()]], 'message' => [trans('api.unknownError')]]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $highlight = $user->highlights()->findOrFail($id);
        $this->deleteImage($highlight);
        $highlight->images()->delete();
        $highlight->delete();
        return $this->apiResponse(200, ['data' => [], 'message' => [trans('api.success')]]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyOneImage($highlight_id , $id)
    {
        $user = Auth::user();
        $highlight = $user->highlights()->findOrFail($highlight_id);
        $image = $highlight->images()->findOrFail($id);
        $web_image_path = "/uploads/highlights/" . $image->image;
        $web_image_paththumb = "/uploads/highlights/thumb/" . $image->image;

        if (File::exists(public_path($web_image_path))) {
            File::delete(public_path($web_image_path));
        }
        if (File::exists(public_path($web_image_paththumb))) {
            File::delete(public_path($web_image_paththumb));
        }
        $image->delete();
        if ( $highlight->images()->count() == 0 )
            $highlight->delete();
        return $this->apiResponse(200, ['data' => [], 'message' => [trans('api.success')]]);
    }

    public function deleteImage($highlight){
        $images = $highlight->images()->get();
        if ( $images != null)
            foreach ( $images as $image) {
                $web_image_path = "/uploads/highlights/" . $image->image;
                $web_image_paththumb = "/uploads/highlights/thumb/" . $image->image;

                if (File::exists(public_path($web_image_path))) {
                    File::delete(public_path($web_image_path));
                }
                if (File::exists(public_path($web_image_paththumb))) {
                    File::delete(public_path($web_image_paththumb));
                }
            }
    }
}
 