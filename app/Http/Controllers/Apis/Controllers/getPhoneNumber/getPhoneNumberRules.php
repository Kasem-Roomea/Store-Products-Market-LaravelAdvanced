<?php

namespace App\Http\Controllers\Apis\Controllers\getPhoneNumber;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Apis\Helper\helper;
use App\Models\users;


class getPhoneNumberRules extends index
{
    public static function rules()
    {

        $rules = [
            "email"    => "required||regex:/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}/|",
        ];

        $messages = [
            "email.required"     => 400,
            "email.regex"        => 405,
            "email.min"          => 405,
        ];

        $messagesAr = [
            "email.required" => "يجب ادخال البريد الالكتوني",
            "email.regex"       => "يجب ادخال البريد الالكتروني بشكل صحيح",

        ];

        $messagesEn = [];
        $ValidationFunction = self::$request->showAllErrors == 1 ? 'showAllErrors' : 'Validator';
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages, self::$lang == "ar" ? $messagesAr : $messagesEn);
        if ($Validation !== null) {
            return $Validation;
        }
        self::$account = users::where('email', request()->email)->first();
        //  return helper::validateAccount() ?? null;
    }
}
