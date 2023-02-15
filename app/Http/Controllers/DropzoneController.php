<?php

namespace App\Http\Controllers;

use App\FreelancerServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;

class DropzoneController extends Controller
{
    protected $possibleModels = [
        'SinglePage' => \App\Singlepage::class,
        'freelancer_services' => \App\FreelancerServices::class,
        'freelancer_workshops' => \App\FreelancerWorkshop::class,
        'FreelancerHighlight' => \App\FreelancerHighlight::class,
    ];

    public function store(Request $request)
    {
        $name = md5(time()) . rand(1000, 9999999) . '.' . $request->file->getClientOriginalExtension();
        $request->file->move(public_path('uploads/junk'), $name);

        return response()->json([
            'name' => $name,
        ]);
    }

    public function destroy(Request $request)
    {
        $model = $this->possibleModels[$request->model];
        $resource = $model::find($request->id);
        $img = "";
        if ($request->model == 'FreelancerHighlight') {
            $image = json_decode($request->name, true)['image'];
            if (File::exists(public_path('uploads/highlights/' . $image)))
                File::delete(public_path('uploads/highlights/' . $image));
            foreach ($resource->images as $item) {
                if ($item->image == $image) {
                    $item->delete();
                    return response($image, 200);
                }
            }
        } else {
            $path = strtolower($request->model) . 's';
            if (File::exists(public_path('uploads/' . $path . '/' . $request->name))) {
                File::delete(public_path('uploads/' . $path . '/' . $request->name));
            }
            $images = $resource->images;
            $ArrImages = explode(',', $images);
            foreach ($ArrImages as $key => $image) {
                if ($image === $request->name) {
                    $img = $image;
                    unset($ArrImages[$key]);
                }
            }
            $resource->images = implode(',', $ArrImages);
            $resource->save();
        }
        return response($img, 200);
    }

}
