<?php
namespace App\Http\Controllers\Apis\Controllers\editOfferPrice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\offers;
use App\Models\appInfo;
use App\Models\price_list;
use App\Models\offers_edited_price;

class editOfferPriceController extends index
{
    public static function api(){

        $offer=  offers::find(self::$request->offerId);
        $order=  $offer->order;
        if($offer->drivers_id != self::$account->id){
            return [
                "status"=>430,
                "message"=>self::$messages['offer']["430"]
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
        $distance= helper::distance( $order->deliveryAddress->latitude, $order->deliveryAddress->longitude,
                                     $order->purchaseAddress->latitude, $order->purchaseAddress->longitude);

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
        $record =   offers::createUpdate([
                "id"=>$offer->id,
                'drivers_id'=>self::$account->id,
                'orders_id'=>$order->id,
                'price'=>self::$request->price,
                "status"=>"waiting"
            ]);
              
        offers_edited_price::createUpdate([
                'offers_id'=>$record->id,
                'price'=>self::$request->price,
            ]);
              
        helper::newNotify(
            [self::$account],
            [   
                "Ar"=>self::$messagesAll["Ar"]['offer']["201"],
                "En"=>self::$messagesAll["En"]['offer']["201"]  
            ]   
        );
        return [
            "status"=>200,
            "offer"=>helper::only([$record],self::$request->parameters)[0],
        ];
    }
}