<?php

namespace App\Http\Controllers\Apis\Controllers\refuseOrder;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\orders;

class refuseOrderController extends index
{
    public static function api(){

        $record=  orders::find(self::$request->orderId);
        if($record->providers_id != self::$account->id )
            return ['status'=>403,'message'=>self::$messages["order"]["403"] ];
        if( $record->status != "waiting")
            return ["status"=>"406","message"=>self::$messages["order"]["407"]];
        $record= orders::createUpdate([
                    'id'=>$record->id,
                    'status'=>'cancelled'
                ]);

        $messageAr=self::$messagesAll["ar"]['notifications']['cancelledOrder'];
        $messageEn= self::$messagesAll["en"]['notifications']['cancelledOrder'];
        helper::newNotify([$record->users],$messageAr,$messageEn,$record->id,'order');
        return [
            "status"=>200,
            "order"=>objects::order($record),
            "message"=>self::$messages['order']["418"]
        ];
    }

}

