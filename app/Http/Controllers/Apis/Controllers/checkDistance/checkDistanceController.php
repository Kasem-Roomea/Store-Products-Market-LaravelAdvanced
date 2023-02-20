<?php

namespace App\Http\Controllers\Apis\Controllers\checkDistance;

use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Models\products;
use App\Models\carts;
use App\Models\stores;
use App\Models\locations;
use App\Models\price_list;
use Illuminate\Support\Arr;

class checkDistanceController extends index
{
    public static function api()
    {
        $message = [];
        error_log("Enter");
        $store = self::getStore();
        $storeLocation = $store->location;
        error_log("-----------------");
        $distance = round(self::checkForDistance($storeLocation), 2);
        error_log("Enter 3");

        $deliveryPrice = 0;
        $price_list = price_list::where('startKm', '<=', $distance)->where('endKm', '>=', $distance)->first();

        if (!$price_list) {
            error_log("Enter 4");

            return [
                'status' => 417,
                'message' => 'location is out of Range, the distance between you and store is ' . $distance . ' Km',
                'maxRange' => price_list::max('endKm')
            ];
        }

        return [
            "status" => 200,
            'distance' => $distance,

        ];
    }

    static function getStore()
    {
        return stores::first();
    }
    static function checkForDistance($location)
    {
        error_log("cccccccccccc");
        return
            helper::distance(
                $location->latitude,
                $location->longitude,
                request()->latitude,
                request()->longitude,
            );
    }
}
