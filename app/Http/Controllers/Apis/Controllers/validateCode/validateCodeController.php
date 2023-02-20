<?php

namespace App\Http\Controllers\Apis\Controllers\validateCode;

use  App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Models\sessions;
use App\Http\Controllers\Apis\Resources\objects;

class validateCodeController extends index
{
    public static function api()
    {

        if (helper::isExpiredSession(self::$account->session, 60))
            return [
                'status' => 410,
                'message' => self::$messages['validateCode']["410"]
            ];

        // first Case :: Forget Password
        if (self::$request->has('phone')) {
            $token = helper::createTmpTokens(self::$account);
            self::$account->isVerified = 1;
            self::$account['apiToken'] = $token;
            self::$account->save();
            sessions::whereIn('id', index::$account->sessions->pluck('id')->toArray())->delete();
            $key = "apiToken";
            $value = $token;
        }
        // Second Case :: Forget Password
        elseif (self::$request->has('tmpToken')) {

            $key = "tmpToken";
            $value = self::$account->session->tmpToken;
        }
        // Third Case :: Update Phone
        elseif (self::$request->has('apiToken')) {

            self::$account->session->tmpPhone ? self::$account->phone = self::$account->session->tmpPhone : null;
            self::$account->session->tmpEmail ? self::$account->email = self::$account->session->tmpEmail : null;
            self::$account->save();
            $key = "phone";
            $value = self::$account->session->tmpPhone;
            sessions::whereIn('id', index::$account->sessions->pluck('id')->toArray())->delete();
        }

        return [
            'status'  => 200,
            $key      => $value,
            'message' => self::$messages['validateCode']["200"],
            'Account' => objects::account(self::$account),
        ];
    }
}
