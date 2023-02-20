<?php
namespace App\Http\Controllers\Apis\Controllers\finishOrder;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\orders;
use App\Models\offers;
use App\Models\users;
use App\Models\financials;
use App\Models\bills;
use App\Models\appInfo;

class finishOrderController extends index
{
    public static function api()
    {
        $record=  orders::find(self::$request->orderId);
        foreach($record->carts as $cart){
            $cart->product->quantity-= $cart->quantity;
            $cart->product->save();
        }

        if($record->drivers_id != self::$account->id){
            return [
                "status"=>403
            ];
        }
        orders::createUpdate([
            "id"=>$record->id,
            "status"=>"finished"
        ]);
        
        // deduct fees from driver balance
        $driverFees= appInfo::first()->driverFees / 100 * $record->bill->deliveryPrice;
        self::$account->balance-=$driverFees;
        self::$account->save();
        

        // deduct fees from driver balance
        $store= $record->store;
        $fees = $store->fees??appInfo::first()->storeFees;
        $storeFees= $fees / 100 * $record->bill->products_price;
        $store->balance-= $fees;
        $store->save();
        
        bills::createUpdate([
            "id"=>$record->bill->id,
            "driverFees"=>round($driverFees,2),
            "storeFees"=>$storeFees
            ]);
        helper::newNotify(
            [$record->user],
            self::$messagesAll["Ar"]["notifications"]["finishedOrder"],
            self::$messagesAll["En"]["notifications"]["finishedOrder"],
            $record->id
        );
        helper::SocketUser($record->users_id, 'finishOrder',  $record );
        users::createUpdate([
            "id"=> $record->users_id,
            "points"=>$record->user->points+$record->carts->sum('points') 
        ]);

        return [
            "status"=>200,
            "message"=>self::$messages["order"]["finished"],
            "bill"=>$record->bill
        ];
    }
}