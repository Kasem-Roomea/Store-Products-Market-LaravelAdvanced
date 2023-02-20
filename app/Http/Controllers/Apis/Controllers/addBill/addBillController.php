<?php
namespace App\Http\Controllers\Apis\Controllers\addBill;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\bills;
use App\Models\bills_details;
use App\Models\appInfo;
use App\Models\offers;

class addBillController extends index
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
        $bill= bills::where("offers_id",self::$request->offerId)->first();
        if(!$bill){
            $bill=    bills::createUpdate([
                    "offers_id"=>self::$request->offerId,
                    "deliveryPrice"=>$record->price,
                    "totalPrice"=>(appInfo::first()->fees/100*$record->price)+$record->price,
                ]);
            }
        bills_details::createUpdate([
            "bills_id"=>$bill->id,
            "offers_id"=>self::$request->offerId,
            "cost"=>self::$request->cost,
            "image"=>self::$request->image
        ]);
        helper::newNotify(
            [$record->order->user],
            [   
                "Ar"=>self::$messagesAll["Ar"]['bill']["200"],
                "En"=>self::$messagesAll["En"]['bill']["200"]  
            ],
            ["key"=>"bills_id","value"=> $bill->id]   
        );
        helper::Socket($record->drivers_id, 'bill', $bill );

        return [
            "status"=>200,
            "bill"=>helper::only([$bill],self::$request->parameters)[0],
        ];
    }
}