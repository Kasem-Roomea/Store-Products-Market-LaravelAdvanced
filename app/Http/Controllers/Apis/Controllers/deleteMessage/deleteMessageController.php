<?php

namespace App\Http\Controllers\Apis\Controllers\deleteMessage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\messages;

class deleteMessageController extends index
{
    public static function api(){

        $record=  messages::createUpdate([
            "id"=>self::$request->messageId,
            "deletedAt"=>date("Y-m-d H:i:s")
        ]);
        return [
            "status"=>200,
        ];
    }
}