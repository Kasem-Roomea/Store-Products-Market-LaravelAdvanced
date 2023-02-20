<?php
namespace App\Http\Controllers\Apis\Controllers\addCouponForUsedLater;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class addCouponForUsedLaterRules extends index
{
    public static function rules (){
        
        $rules=[
            "apiToken"   =>"required",
            "code"       =>"required|exists:codes,code",
        ];

        $messages=[
            "apiToken.required"     =>400,
            "apiToken.exists"       =>405,

            "code.required"         =>400,
            "code.exists"           =>416,
        ];

        $messagesAr=[   
            "apiToken.required"     =>"يجب ادخال التوكن",
            "apiToken.exists"       =>"هذا التوكن غير موجود",

            "code.exists"           =>"هذا الكود غير موجود",
            "code.required"         =>"يجب ادخال رقم الكود",
        ];

        $messagesEn=[
        ];
        $ValidationFunction=self::$request->showAllErrors==1?"showAllErrors":"Validator";
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }

        return helper::validateAccount()??null;
    }
}
