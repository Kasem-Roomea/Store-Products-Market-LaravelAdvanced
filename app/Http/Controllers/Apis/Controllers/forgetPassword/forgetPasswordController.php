<?php

namespace App\Http\Controllers\Apis\Controllers\forgetPassword;

use  App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\sessions;
use App\Http\Controllers\Apis\Helper\helper;

class forgetPasswordController extends index
{
    public static function api()
    {

        sessions::whereIn('id', self::$account->sessions->pluck('id')->toArray())->delete();
        $session =  sessions::createUpdate([
            self::$account->getTable() . '_id' => self::$account->id,
            'tmpToken' => helper::UniqueRandomXChar(69, 'tmpToken', ['sessions']),
            'code' => helper::RandomXDigits(4)
        ]);
        helper::sendSMS(self::$account->phone, $session->code);
        return ['status' => 200, 'tmpToken' => $session->tmpToken, "phoneNumber" => self::$account->phone];
    }
}
