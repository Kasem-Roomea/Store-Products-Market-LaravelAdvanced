<?php

namespace App\Http\Controllers\Apis\Controllers\getNewProducts;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Helper\helper;

class getNewProductsRules extends index
{
    public static function rules()
    {
        $rules = [
            "resultSize"  => "required",
        ];

        $messages = [
            "resultSize.required"     => 400,
        ];

        $messagesAr = [
            "resultSize.required"     => "يجب ادخال عدد النتائج",
        ];

        $messagesEn = [];
        $ValidationFunction = self::$request->showAllErrors == 1 ? "showAllErrors" : "Validator";
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages, self::$lang == "ar" ? $messagesAr : $messagesEn);
        if ($Validation !== null) {
            return $Validation;
        }

        return helper::validateAccount() ?? null;
    }
}
