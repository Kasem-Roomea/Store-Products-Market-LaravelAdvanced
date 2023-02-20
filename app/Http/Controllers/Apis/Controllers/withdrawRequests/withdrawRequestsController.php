<?php

namespace App\Http\Controllers\Apis\Controllers\withdrawRequests;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\withdraw_requests;

class withdrawRequestsController extends index
{
    public static function api(){

        $records=  withdraw_requests::createUpdate([
            "drivers_id"=>self::$account->id,
            "smartWallet"=>self::$request->smartWallet,
            "email"=>self::$request->email,
            "status"=>"waiting",
            "isApproved"=>0
        ]);
        return [
            "status"=>200,
            "message"=>self::$messages["withdrawRequests"]["200"]
        ];
    }
}