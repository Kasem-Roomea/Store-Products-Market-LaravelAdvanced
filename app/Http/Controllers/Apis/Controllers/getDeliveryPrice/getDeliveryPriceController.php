<?php

namespace App\Http\Controllers\Apis\Controllers\getDeliveryPrice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Models\stores;
use App\Models\price_list;

class getDeliveryPriceController extends index
{
    public static function api()
    {
        $store= stores::find(self::$request->storeId);
        $longitude = self::$request->location['longitude'];
        $latitude = self::$request->location['latitude'];
        $distance = helper::distance($store->location->latitude??0,$store->location->longitude??0, $latitude, $longitude );
        $price_list = price_list::where('startKm','>=',$distance)->where('endKm','<=',$distance)->first();
        $delivery_price =$price_list->price??price_list::orderBy('id','DESC')->first()->price;

        return [
            "status"=>200,
            "delivery_price"=>$delivery_price
        ];
    }
}

