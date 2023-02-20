<?php

namespace App\Http\Controllers\Apis\Controllers\acceptOffer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\offers;
use App\Models\orders;
use App\Models\users;

class acceptOfferController extends index
{
    public static function api(){

        $record=  offers::find(self::$request->offerId);
        if(self::$account->id != $record->order->users_id){
            return [
                "status"=>403,
                "message"=>self::$messages['order']["403"]
            ];
        }
        if($record->status != "waiting" || $record->order->status != "waiting" ){
            return [ 
                "status"=>419,
                "message"=>self::$messages['offer']["419"]
            ];
        }
        offers::CreateUpdate([
            "id"=>$record->id,
            "status"=>"accept"
        ]);
        helper::newNotify(
            [$record->driver],
            [   
                "Ar"=>self::$messagesAll["Ar"]['offer']["203"],
                "En"=>self::$messagesAll["En"]['offer']["203"]  
            ],
            ["key"=>"offers_id","value"=>$record->id]   
        );

        orders::CreateUpdate([
            "id"=> $record->order->id,
            "status"=>"accept"
        ]);
        helper::Socket($record->drivers_id, 'offer',  $record );
        $users=users::find( offers::where("orders_id",$record->orders_id)->where('status',"waiting")->pluck('drivers_id')->toArray() );
        foreach($users as $user){
            helper::newNotify(
                [$user],
                [   
                    "Ar"=>self::$messagesAll["Ar"]['offer']["426"],
                    "En"=>self::$messagesAll["En"]['offer']["426"]  
                ],
                ["key"=>"orders_id","value"=>$record->orders_id]   
            );
        }
        $offers = offers::where("status","waiting")->where('orders_id',$record->orders_id)->get();
        foreach($offers as $offer){
            offers::createUpdate([
                'id'=>$offer->id,
                "status"=>"cancel",
            ]);
        }
        return [
            "status"=>200,
            "message"=>self::$messages['offer']["200"]
        ];
    }
}

