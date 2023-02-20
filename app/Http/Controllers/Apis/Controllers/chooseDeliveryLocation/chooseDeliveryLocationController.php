<?php

namespace App\Http\Controllers\Apis\Controllers\chooseDeliveryLocation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\orders;
use App\Models\bills;
use App\Models\myAddress;
use App\Models\appInfo;
use App\Models\price_list;
use App\Models\days_list;

class chooseDeliveryLocationController extends index
{
    public static function api()
    {
        $myAddress = myAddress::find(self::$request->locationId);

        $distance   = helper::distance($myAddress->latitude, $myAddress->longitude, 24.4768134, 54.3551751);
        $days_list = days_list::where('startKm', '<=', $distance)
            ->where('endKm', '>=', $distance)
            ->first();
        if (!$days_list)
            $days_list = days_list::orderBy('id', 'desc')->first();


        $price_list = price_list::where('startKm', '<=', $distance)
            ->where('endKm', '>=', $distance)->first();
        if (!$price_list)
            $price_list = price_list::orderBy('id', 'desc')->first();

        // 24.4768134,54.3551751
        $expectedTime = $days_list->days;
        if (self::$lang == 'En') {
            if ($expectedTime == 0)
                $expectedTime = "Today";
            elseif ($expectedTime == 1)
                $expectedTime = "Tomorrow";
            elseif ($expectedTime > 1)
                $expectedTime = "In " . $expectedTime . " days";

            $expectedStr = $expectedTime;
        } else {
            if ($expectedTime == 0)
                $expectedTime = "اليوم";
            elseif ($expectedTime == 1)
                $expectedTime = "غدا";
            elseif ($expectedTime > 1)
                $expectedTime = "بعد " . $expectedTime . " أيام";

            $expectedStr = $expectedTime;
        }
        return [
            "status" => 200,
            "minPrice" => $price_list->minPriceForOrder,
            "delivery_price" => $price_list->price,
            "expectedTime" => $days_list->days,
            'distance' => round($distance, 3) . ' Km',
            "expectedStr" => $expectedStr,

        ];
    }
}
