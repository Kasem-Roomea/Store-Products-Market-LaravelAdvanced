<?php
namespace App\Http\Controllers\Apis\Controllers\cancelOffer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\offers;
use App\Models\bills;
use App\Models\users;
use App\Models\reason_to_cancel;

class cancelOfferController extends index
{
    public static function api()
    {
        $record=  offers::find(self::$request->offerId);
        if(self::$account->id != $record->drivers_id){
            return [
                "status"=>430,
                "message"=>self::$messages['offer']["430"]
            ];
        }
        $bill = bills::where("offers_id",$record->id)->first();
        if($bill){
            return [
                "status"=>419,
                "message"=>self::$messages['offer']["419"]
            ];

        }
        offers::createUpdate([
            'id'=>$record->id,
            "status"=>"cancel",
            "reason_to_cancel_id"=>self::$request->resonId
        ]);
        $users= helper::nearst(users::find( offers::where("orders_id",$record->orders_id)->pluck('drivers_id')->toArray() ), $record->order->deliveryAddress);
        foreach($users as $user){
            helper::newNotify(
                [$user],
                [   
                    "Ar"=>self::$messagesAll["Ar"]['order']["426"],
                    "En"=>self::$messagesAll["En"]['order']["426"]  
                ],
                ["key"=>"orders_id","value"=>$record->orders_id]   
            );
        }

        return [
            "status"=>200,
            "message"=>self::$messages["offer"]["cancelled"]
         ];
    }
}