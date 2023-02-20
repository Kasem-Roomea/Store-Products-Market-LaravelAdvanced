<?php

namespace App\Http\Controllers\Apis\Controllers\getOffers;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class getOffersRules extends index
{
    public static function rules()
    {
        $rules = [
            "categoryId" => "exists:categories,id",
            "page"      => "required_if:productId,|numeric"
        ];

        $messages = [

            "categoryId.exists"     => 405,

            "page.required_if"      => 400,
            "page.numeric"          => 405
        ];

        $messagesAr = [

            "categoryId.exists"     => "هذا القسم غير موجود",

            "brandId.exists"        => "هذه العلامة التجارية غير موجود",

            "storeId.exists"         => "هذا المتجر غير موجود",

            "page.required_if"      => "يجب ادخال رقم الصفحة",
            "page.numeric"          => "يجب ادخال رقم الصفحة بشكل صحيح",
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
