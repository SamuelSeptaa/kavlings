<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //Yajra Datatable Custom Function
    protected function YajraFilterValue(
        $filterValue,
        $query,
        $columnFilter,
        $join = false,
        $table = null,
        $columnRelation = null,
        $tableJoin = null
    ) {
        if ($join)
            $query->join($tableJoin, "$table.$columnRelation", '=', "$tableJoin.id");

        $filterValue = json_decode($filterValue);
        if (!empty($filterValue)) {
            $query->whereIn($columnFilter, $filterValue);
        }
    }

    protected function YajraColumnSearch($query, $columnSearch, $searchValue)
    {
        $query->where(function ($query) use ($columnSearch, $searchValue) {
            $i = 0;
            foreach ($columnSearch as $item) {
                if ($i == 0)
                    $query->where($item, 'like', "%{$searchValue}%");
                else
                    $query->orWhere($item, 'like', "%{$searchValue}%");
                $i++;
            }
        });
    }
}
