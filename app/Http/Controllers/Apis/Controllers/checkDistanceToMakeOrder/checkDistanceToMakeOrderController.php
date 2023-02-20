<?php

namespace App\Http\Controllers\Apis\Controllers\checkDistanceToMakeOrder;

use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Models\products;
use App\Models\carts;
use App\Models\stores;
use App\Models\locations;
use App\Models\price_list;
use Illuminate\Support\Arr;

class checkDistanceToMakeOrderController extends index
{
    public static function api()
    {
        $message = [];
        error_log("Enter");
        $carts = carts::where('users_id', self::$account->id)->where('orders_id', null)->get();
        if ($carts->count() == 0) return ['message' => 'your cart is empty.'];
        $products = products::find($carts->pluck('products_id'));
        error_log("Enter 2");

        $store = self::getStore();
        $storeLocation = $store->location;
        error_log($storeLocation);
        error_log("-----------------");

        $check_delivery_price = $products->sum("isFreeDelivered") / $products->count();
        error_log("rrrrrrrrr");
        $distance = round(self::checkForDistance($storeLocation), 2);
        error_log("Enter 3");

        $deliveryPrice = 0;
        $price_list = price_list::where('startKm', '<=', $distance)->where('endKm', '>=', $distance)->first();

        if ($check_delivery_price != 1 && !$price_list) {
            // if(!$price_list)
            error_log("Enter 4");

            return [
                'status' => 417,
                'message' => 'location is out of Range, the distance between you and store is ' . $distance . ' Km',
                'maxRange' => price_list::max('endKm')
            ];
            $deliveryPrice = $price_list->price;
        }
        error_log("Enter 5");

        return [
            "status" => 200,
            'deliveryPrice' => $price_list->price,
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
                request()->orderLocation['latitude'],
                request()->orderLocation['longitude'],
            );
    }
}
