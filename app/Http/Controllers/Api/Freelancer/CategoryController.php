<?php

namespace App\Http\Controllers\Api\Freelancer;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        config(['translatable.locale' => request()->header('accept-language')]);
        $user = Auth::user();
        $categoriesId = $user->categories()->get()->pluck('id')->toArray();
        $categories = Category::where('parent_id' , null )->whereIn('id',$categoriesId)->orderBy('display_order')->with(['children' => function($query) use($categoriesId) {
            $query->whereIn('id',$categoriesId);
        }])->get()->toArray();
        $categories = $this->deleteTranslations($categories);
        return $this->apiResponse(200, ['data' => ['categories' => $categories], 'message' => []]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
//            "category_id" => "required|array|max:2",
            'category_id.*'=>'required|numeric|exists:categories,id',
        ]);
        $i = 0 ;
        foreach ( $request->category_id as $id ){
            $cat = Category::where('parent_id', null)->find($id);
            if ( $cat != null )
                $i++;
        }
        if ( $i > 2 )
            return $this->apiResponse(422, ['data' => [], 'message' => [trans('api.numCat')]]);
        $user = Auth::user();
        $user->categories()->sync($request->category_id);
        return $this->apiResponse(200, ['data' => [], 'message' => [trans('api.catSaved')]]);
    }


    public function getParentCategory()
    {
        config(['translatable.locale' => request()->header('accept-language')]);
        $categories = Category::where('parent_id', null)->get()->toArray();
        $categories = $this->deleteTranslations($categories);
        foreach ($categories as $i => $category){
            $categories[$i]['sub'] = Category::orderBy('display_order')->findOrFail($category['id'])->childrenRecursive->toArray();
            $categories[$i]['sub'] = $this->deleteTranslations($categories[$i]['sub']);
        }
        return $this->apiResponse(200, ['data' => ['categories' => $categories], 'message' => []]);
    }

    public function getSubCategories(Request $request)
    {
        config(['translatable.locale'  => request()->header('accept-language')]);
        if ( $request->has('id') ){
            $categories = Category::orderBy('display_order')->findOrFail($request->id)->childrenRecursive->toArray();
        } else {
            $categories = Category::where('parent_id' , null )->orderBy('display_order')->with('children')->get()->toArray();
        }
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
