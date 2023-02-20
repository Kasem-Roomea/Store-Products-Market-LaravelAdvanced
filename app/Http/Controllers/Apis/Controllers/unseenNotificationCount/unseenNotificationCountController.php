<?php

namespace App\Http\Controllers\Apis\Controllers\unseenNotificationCount;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper ;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\notify;

class unseenNotificationCountController extends index
{
    public static function api(){

        $count=  notify::where(self::$account->getTable().'_id',self::$account->id)->where('isSeen',0)->count();
        return [
            "status"=>200,
            "count"=>$count
        ];
    }
}