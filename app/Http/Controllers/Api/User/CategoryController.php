<?php

namespace App\Http\Controllers\Api\User;

use App\Category;
use App\Freelancer;
use App\FreelancerUserMessage;
use App\FreelancerWorkshop;
use App\Slideshow;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class CategoryController extends Controller
{
    public function getParentCategory()
    {
        config(['translatable.locale' => request()->header('accept-language')]);
        $categories = Category::where('parent_id', null)->get()->toArray();
        $categories = $this->deleteTranslations($categories);
        return $this->apiResponse(200, ['data' => ['categories' => $categories], 'message' => []]);
    }

    public function getSubCategories(Request $request)
    {
        config(['translatable.locale'  => request()->header('accept-language')]);
        $categories = Category::find($request->id)->childrenRecursive->toArray();
        $categories = $this->deleteTranslations($categories);
        return $this->apiResponse(200, ['data' => ['sub_category' =>$categories ], 'message' => []]);
    }

    private function deleteTranslations($datas)
    {
        if ( is_array($datas)){
            foreach ($datas as $index => $data){
                if ( isset($data['children_recursive']) and is_array($data['children_recursive']) and count($data['children_recursive']) > 0)
                    $datas[$index]['children_recursive'] = $this->deleteTranslations($data['children_recursive']);
                unset($datas[$index]['translations']);
            }
        }
        return $datas;
    }
}
