<?php

namespace App\Http\Controllers\Apis\Controllers\review;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\reviews;

class reviewController extends index
{
    public static function api()
    {
        $provider= self::$account->type;
        if(self::$request->type == "shop"){
            $type="ToShop";
            $key="shops_id";
            $val=self::$request->shopId;
        }
        elseif(self::$request->type == "product"){
            $type="ToProduct";
            $key="products_id";
            $val=self::$request->productId;
        }
        else{
            if(self::$account->isDriver== 0){
                $type="ToDriver";
                $key="drivers_id";
                $val=self::$request->targetId;
            }else{
                $type="ToUser";
                $key="users_id";
                $val=self::$account->targetId;
            }
        }
        return [$key,$val];
        $records=  reviews::createUpdate([
            'type'=>$provider.$type,
            "rate"=>self::$request->rating,
            "comment"=>self::$request->comment,
            "orders_id"=>self::$requet->orderId,
            $key=>$val
        ]);
        return [
            "status"=>200,
        ];
    }
}