<?php

namespace App\Http\Controllers\Apis\Controllers\loginBySocialToken;

use  App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\notifications;
use App\Http\Controllers\Apis\Helper\helper;
use App\Models\tokens;

class loginBySocialTokenController extends index
{
    public static function api()
    {
        $token = helper::UniqueRandomXChar(69, 'apiToken');
        error_log(self::$account);
        tokens::create([
            'apiToken' => $token,
            self::$account->getTable() . '_id' => self::$account->id,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        self::$account->apiToken = $token;
        return  [
            'status' => 200,
            'Account' => objects::account(self::$account),
            'message' => index::$lang == 'Ar' ? 'تم تسجيل الدخول بنجاح' : 'login successfully'
        ];
    }
}
