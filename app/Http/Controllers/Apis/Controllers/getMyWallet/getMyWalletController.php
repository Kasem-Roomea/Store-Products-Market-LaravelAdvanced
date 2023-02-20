<?php

namespace App\Http\Controllers\Apis\Controllers\getMyWallet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Resources\walletResource;
use App\Http\Controllers\Apis\Controllers\index;

class getMyWalletController extends index
{
    public static function api()
    {
        return [
            "status"=>200,
            "wallet"=>new walletResource(self::$account)
        ];
    }
}

