<?php

namespace App\Http\Controllers\Apis\Controllers\unseenMessage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\messages;

class unseenMessageController extends index
{
    public static function api(){

        $count=  messages::where(self::$account->getTable()."_id",self::$account->id)
                            ->where("isSeen",0)
                           ->count();
        return [
            "status"=>200,
            "unseen"=>$count
        ];
                    

    }
}

