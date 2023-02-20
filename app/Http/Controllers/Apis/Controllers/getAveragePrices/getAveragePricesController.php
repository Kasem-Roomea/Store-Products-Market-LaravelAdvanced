<?php

namespace App\Http\Controllers\Apis\Controllers\getAveragePrices;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\offers;

class getAveragePricesController extends index
{
    public static function api(){

        $price=  offers::where("orders_id",self::$request->orderId)->avg("price");

        if($price == 0){
            return [
             "status"=>204,
             "message"=>self::$messages["getAveragePrices"]["204"]   
            ];
        }
        return [
            "status"=>200,
            "price"=>$price
        ];
    }
}

