<?php

namespace App\Http\Controllers\Apis\Controllers\rateStore;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\rates;

class rateStoreController extends index
{
    public static function api(){

        $rates= rates::where('users_id',self::$account->id)->where('stores_id',self::$request->storeId)->first();
        if($rates)
            $rates->delete();
        
        rates::createUpdate([
            'users_id'=>self::$account->id,
            'stores_id'=>self::$request->storeId,
            'rate'=>self::$request->rate,
            'comment'=>self::$request->comment
        ]);
        $message=self::$messages['rate']['200'];
        return [
            "status"=>200,
            "message"=>$message,
        ];
    }
}