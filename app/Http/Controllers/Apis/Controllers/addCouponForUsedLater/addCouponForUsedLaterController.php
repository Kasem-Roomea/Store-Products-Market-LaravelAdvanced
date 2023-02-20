<?php
namespace App\Http\Controllers\Apis\Controllers\addCouponForUsedLater;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\codes;
use App\Models\code_used;

class addCouponForUsedLaterController extends index
{
    public static function api(){
        
        $record=  codes::where("code",self::$request->code)->first();
        if(!$record->isActive || $record->endDate < date("Y-m-d") ){
            return [
                "status"=>413,
                "message"=>self::$messages["codes"]["413"],
            ];
        }
        if(!$record->quantity){
            return [
                "status"=>414,
                "message"=>self::$messages["codes"]["414"],
            ];
        }
        if(code_used::where("codes_id",$record->id)->where("users_id",self::$account->id)->where("isUsed",1)->count()){
            return [
                "status"=>415,
                "message"=>self::$messages["codes"]["415"],
            ];
        }
        code_used::createUpdate([
            "codes_id"=>$record->id,
            "users_id"=>self::$account->id,
            "isUsed"=>0
        ]);        
        $record->quantity--;
        $record->save();
        return [
            "status"=>200,
            "message"=>self::$messages["codes"]["200"]
        ];
    }
}