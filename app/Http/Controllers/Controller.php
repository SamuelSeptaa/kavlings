<?php

namespace App\Http\Controllers;

use App\Mail\OrderNotification;
use App\Models\Order;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Mail;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //Yajra Datatable Custom Function    
    /**
     * YajraFilterValue
     * @param string $filterValue from request->filterValue
     * @param mixed $query
     * @param string $columnFilter kolom yang difilter
     * @param bool $join apakah join dngn tabel lain
     * @param string $columnRelation
     * @param string $tableJoin
     * @return void
     */

    protected $data = array();
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

    /**
     * YajraColumnSearch
     *
     * @param  mixed $query
     * @param  array $columnSearch
     * @param  string $searchValue
     * @return void
     */
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

    /**
     * filterDateRange
     *
     * @param  mixed $query
     * @param  string $columnFilter
     * @param  object $request
     * @return void
     */
    protected function filterDateRange($query, $columnFilter, $request)
    {
        if ($request->startDate && $request->endDate) {
            $query->where($columnFilter, '>=', "$request->startDate 00:00:00");
            $query->where($columnFilter, '<=', "$request->endDate 23:59:59");
        }
    }
}
