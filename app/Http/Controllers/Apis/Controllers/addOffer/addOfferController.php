<?php

namespace App\Http\Controllers\Apis\Controllers\addOffer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\appInfo;
use App\Models\orders;
use App\Models\offers;
use App\Models\price_list;

class addOfferController extends index
{
    public static function api(){

        $order=  orders::find(self::$request->orderId);
        if($order->status != "waiting"){
            return [
                "status"=>407,
                "message"=>self::$messages['offer']["407"]
            ];
        }
        if(self::$account->isDriver!=1){
            return [
                "status"=>408,
                "message"=>self::$messages['offer']["408"]
            ];
        }
        if(appInfo::first()->minimumBalance > self::$account->driverBalance){
            return [
                "status"=>422,
                "message"=>self::$messages['offer']["422"]
            ];
        }
        $distance= helper::distance( $order->deliveryAddress->latitude??0, $order->deliveryAddress->longitude??0,
                                     $order->purchaseAddress->latitude??0, $order->purchaseAddress->longitude??0);

        $price_list = price_list::where('vehicles_id',self::$account->vehicles_id)
                                ->where("startKm","<=",$distance)
                                ->where("endKm",">=",$distance)
                                ->first();
        if($price_list && ($price_list->minPrice > self::$request->price || $price_list->maxPrice < self::$request->price)  ){
            return [
                "status"=>423,
                "message"=>self::$messages['offer']["422"]
            ];
                }
        $lastOffers = offers::where("drivers_id",self::$account->id)->where('orders_id',$order->id)->get();
        foreach($lastOffers as $offer){
            if($offer){    
                offers::createUpdate([
                    'id'=>$offer->id,
                    'status'=>'cancel'
                ]); 
            }
        }
        $record =   offers::createUpdate([
                'drivers_id'=>self::$account->id,
                'orders_id'=>$order->id,
                'price'=>self::$request->price,
                "status"=>"waiting"
            ]);
              
        helper::newNotify(
            [self::$account],
            [   
                "Ar"=>self::$messagesAll["Ar"]['offer']["201"],
                "En"=>self::$messagesAll["En"]['offer']["201"]  
            ]   
        );
        helper::Socket($order->users_id, 'offer', $record );
        return [
            "status"=>200,
            "offer"=>helper::only([$record],self::$request->parameters)[0],
        ];
    }
}