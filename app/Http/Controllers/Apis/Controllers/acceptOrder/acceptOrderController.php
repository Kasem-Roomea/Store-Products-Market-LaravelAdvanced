<?php

namespace App\Http\Controllers\Apis\Controllers\acceptOrder;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\orders;

class acceptOrderController extends index
{
    public static function api(){
        $record=  orders::find(self::$request->orderId);
        if($record->providers_id != self::$account->id )
            return ['status'=>403,'message'=>self::$messages["order"]["403"] ];
        if( $record->status != "waiting")
            return ["status"=>"406","message"=>self::$messages["order"]["406"]];
        $record =   orders::createUpdate([
                        'id'=>$record->id,
                        'status'=>'accepted'
                    ]);

        $messageAr=self::$messagesAll["ar"]['notifications']['acceptOrder'];
        $messageEn= self::$messagesAll["en"]['notifications']['acceptOrder'];
        helper::newNotify([$record->users],$messageAr,$messageEn,$record->id,'order');
        return [
            "status"=>200,
            "order"=>objects::order($record),
            "message"=>self::$messages['order']["accepted"]
        ];
    }
}