<?php
namespace App\Http\Controllers\Apis\Controllers\getShops;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class getShopsRules extends index
{
    public static function rules ()
    {
        $rules=[
            "page"      =>"required|numeric"
        ];

        $messages=[
            "page.required"         =>400,
            "page.numeric"          =>405
        ];

        $messagesAr=[   
            "page.required"         =>"يجب ادخال رقم الصفحة",
            "page.numeric"          =>"يجب ادخال رقم الصفحة بشكل صحيح",
        ];

        $messagesEn=[
        ];
        $ValidationFunction=self::$request->showAllErrors==1?"showAllErrors":"Validator";
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="Ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }
    }
}
