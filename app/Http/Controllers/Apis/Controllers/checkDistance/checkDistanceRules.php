<?php

namespace App\Http\Controllers\Apis\Controllers\checkDistance;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class checkDistanceRules extends index
{
    public static function rules()
    {
        $rules = [
            "longitude" => "required",
            "latitude" => "required",

        ];

        $messages = [
            "longitude.required"                  => 400,
            "latitude.required"                  => 400,
        ];

        $messagesAr = [
            "longitude.required"                  => "يجب ادخال خطوط الطول",
            "latitude.required"                  => "يجب ادخال خطوط العرض",

        ];
        $messagesEn = [];
        $ValidationFunction = self::$request->showAllErrors == 1 ? "showAllErrors" : "Validator";
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages, self::$lang == "Ar" ? $messagesAr : $messagesEn);
        if ($Validation !== null) {
            return $Validation;
        }

        return helper::validateAccount() ?? null;
    }
}
