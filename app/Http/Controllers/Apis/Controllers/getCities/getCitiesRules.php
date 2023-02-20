<?php
namespace App\Http\Controllers\Apis\Controllers\getCities;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class getCitiesRules extends index
{
    public static function rules ()
    {
        $rules=[
            "countryId"   =>"required|exists:regions,id",
            "page"        =>"required|numeric"
        ];

        $messages=[
            "countryId.required"    =>400,
            "countryId.exists"      =>405,

            "page.required"         =>400,
            "page.numeric"          =>405
        ];

        $messagesAr=[   
            "countryId.exists"      =>"هذه المنطقة غير موجودة",
            "countryId.required"    =>"يجب ادخال رقم المنطقة",

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