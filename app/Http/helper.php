<?php

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