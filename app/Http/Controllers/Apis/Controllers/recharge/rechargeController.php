<?php

namespace App\Http\Controllers\Apis\Controllers\recharge;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\recharges;

class rechargeController extends index
{
    public static function api(){

        $record=  recharges::createUpdate([
            'amount'=>self::$request->amount,
            'image'=>self::$request->image,
            self::$account->getTable()."_id"=>self::$account->id,
            "status"=>"waiting"
        ]);
        return [
            "status"=>200,
            "code"=>$record->code
        ];
    }
}