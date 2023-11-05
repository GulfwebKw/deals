<?php

use App\Settings;

if (! function_exists('paginate')) {
    function paginate($items, $perPage)
    {
        $pageStart = request('page', 1);
        $offSet    = ($pageStart * $perPage) - $perPage;
        $itemsForCurrentPage = $items->slice($offSet, $perPage);
        return new Illuminate\Pagination\LengthAwarePaginator(
            $itemsForCurrentPage, $items->count(), $perPage,
            Illuminate\Pagination\Paginator::resolveCurrentPage(),
            ['path' => Illuminate\Pagination\Paginator::resolveCurrentPath()]
        );
    }
}
if (! function_exists('websiteName')) {
    function websiteName($isEnglish = true)
    {
        $settings = cache()->remember('websiteName' , 60 , function (){
            return Settings::where("keyname", "setting")->first();
        });
        if ( $isEnglish )
            return $settings->name_en;
        return $settings->name_ar;
    }
}