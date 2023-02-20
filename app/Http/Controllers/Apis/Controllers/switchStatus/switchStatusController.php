<?php

namespace App\Http\Controllers\Apis\Controllers\switchStatus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\ModelName;

class switchStatusController extends index
{
    public static function api(){

        if(self::$account->isDriver){
            self::$account->isDriver=0;
            self::$account->isOnline=0;
            self::$account->save();
        }else{
            self::$account->isDriver=1;
            self::$account->isOnline=1;
            self::$account->save();
            
        }
        return [
            "status"=>200,
        ];
    }
}