<?php

namespace App\Http\Controllers\Apis\Controllers\deleteNotification;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\notify;

class deleteNotificationController extends index
{
    public static function api(){
        $col=self::$account->getTable()."_id";
        if(notify::find(self::$request->notificationId)->$col != self::$account->id)
            return [
                'status'=>403,
                "message"=>self::$message["notifications"]["403"]
            ];
        notify::destroy(self::$request->notificationId);
        return [
            "status"=>200,
        ];
    }
}