<?php
namespace App\Http\Controllers\Apis\Controllers\getDistricts;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class getDistrictsRules extends index
{
    public static function rules ()
    {
        $rules=[
            "cityId"     =>"required|exists:regions,id",
            "page"       =>"required|numeric"
        ];

        $messages=[
            "cityId.required"       =>400,
            "cityId.exists"         =>405,

            "page.required"         =>400,
            "page.numeric"          =>405
        ];

        $messagesAr=[   
            "cityId.exists"         =>"هذه المنطقة غير موجودة",
            "cityId.required"       =>"يجب ادخال رقم المنطقة",

            "page.required"         =>"يجب ادخال رقم الصفحة",
            "page.numeric"          =>"يجب ادخال رقم الصفحة بشكل صحيح",
        ];

        $messagesEn=[
        ];
        $ValidationFunction=self::$request->showAllErrors==1?"showAllErrors":"Validator";
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }
        return helper::validateAccount()??null;
    }
}