<?php

namespace App\Http\Controllers\Apis\Controllers\onlinePaymentConfirm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\online_payment_confirm;

class onlinePaymentConfirmController extends index
{
    public static function api()
    {
        if(self::$request->paid){
            $online_payment_confirm= online_payment_confirm::where("orders_id",self::$request->orderId)->first();
            $online_payment_confirm->check= 1;
            $online_payment_confirm->save();
            
            helper::newNotify([$online_payment_confirm->order->store], self::$messagesAll["Ar"]["order"]["store"], self::$messagesAll["En"]["order"]["store"], self::$request->orderId , null,null, self::$messagesAll["Ar"]["order"]["titleMakeOrder"], self::$messagesAll["En"]["order"]["titleMakeOrder"]);
            helper::SocketStore($online_payment_confirm->order->carts->first()->product->store->id,'makeOrder',objects::order($online_payment_confirm->order));

        }
        
        return [
            "status"=>200,
            "check"=>online_payment_confirm::where("orders_id",self::$request->orderId)->first()->where("check",1)->count() > 0?true:false
        ];
    }
}