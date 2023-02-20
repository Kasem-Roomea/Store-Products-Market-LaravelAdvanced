<?php

namespace App\Http\Controllers\Apis\Controllers\anonymousLogin;

use  App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Helper\helper;


class anonymousLoginRules extends index
{

    public static function rules()
    {
        $rules = [
            "name"              => "required",
        ];

        $messages = [
            "name.required"      => 400,

        ];

        $messagesAr = [

            "name.required"     => "يجب ادخال التوكن",
        ];

        $messagesEn = [];
        $ValidationFunction = self::$request->showAllErrors == 1 ? 'showAllErrors' : 'Validator';
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages, self::$lang == "Ar" ? $messagesAr : $messagesEn);
        if ($Validation !== null) {
            return $Validation;
        }
    }
}
