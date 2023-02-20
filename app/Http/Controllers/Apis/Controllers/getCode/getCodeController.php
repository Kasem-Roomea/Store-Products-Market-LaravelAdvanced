<?php
namespace App\Http\Controllers\Apis\Controllers\getCode;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\codes;
use App\Models\stores;

class getCodeController extends index
{
    public static function api()
    {

        $store = stores::find(self::$request->storeId);
        if($store->discountCode != self::$request->discountCode  ){
            return [
                "status"=>406,
                "message"=>"this code not exist in this store , exists at another store. "
            ];
        }elseif(!$store->has_offer){
            return [
                "status"=>407,
                "message"=>"expired code ."
            ];
        }else{
            $discount=  $store->discount;
        }
        // if($store->discountCode == self::$request->discountCode && $store->has_offer){
        //     $discount=  $store->discount;
        // }else{
        //     return [
        //         "status"=>405,
        //         "message"=>"invalid code."
        //     ];
        // }
        return [
            "status"=>200,
            "discount"=>$discount
        ];
    }
}