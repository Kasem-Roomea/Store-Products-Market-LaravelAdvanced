<?php

namespace App\Http\Controllers\Apis\Controllers\getOffers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\offers;
use App\Models\products;


class getOffersController extends index
{
    public static function api()
    {
        if (self::$request->has('sortBy')) {
            $sortBy = self::$request->sortBy;
            $isDesc = self::$request->isDesc;
            $records =  products::whereHas('offers', function ($query) {
                $query->where('isActive', 1)
                    ->where('startAt', '<=', date('Y-m-d'))
                    ->where('endAt', '>=', date('Y-m-d'));
            })->with('offers')->orderBy($sortBy,  $isDesc == "false" ? 'asc' : 'desc');
        } else {
            error_log("section 3");
            $records = products::whereHas('offers', function ($query) {
                $query->where('isActive', 1)
                    ->where('startAt', '<=', date('Y-m-d'))
                    ->where('endAt', '>=', date('Y-m-d'));
            })->with('offers');
        }


        // if(self::$request->has('storeId')){
        //     $records = $records->where('shops_id',self::$request->shopId);
        // }
        return [
            "status" => $records->forPage(self::$request->page + 1, self::$itemPerPage)->count() ? 200 : 204,
            "totalPages" => ceil($records->count() / self::$itemPerPage),
            "products" => objects::ArrayOfObjects($records->forPage(self::$request->page + 1, self::$itemPerPage)->get(), "product"),
        ];
    }
}
