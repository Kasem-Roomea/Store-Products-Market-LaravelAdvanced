<?php

namespace App\Http\Controllers\Apis\Controllers\getCategories;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class getCategoriesRules extends index
{
    public static function rules()
    {

        $rules = [
            "page"      => "required|numeric",
            "categoryId"   => "exists:categories,id"
        ];

        $messages = [
            "page.required"         => 400,
            "page.numeric"          => 405,

            "categoryId.exists"        => 405,
        ];

        $messagesAr = [
            "page.required"         => "يجب ادخال رقم الصفحة",
            "page.numeric"          => "يجب ادخال رقم الصفحة بشكل صحيح",

            "categoryId.exists"        => "رقم القسم غير صحيح"
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
