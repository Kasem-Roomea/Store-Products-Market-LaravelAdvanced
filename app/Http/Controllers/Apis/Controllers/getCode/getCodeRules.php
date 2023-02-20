<?php
namespace App\Http\Controllers\Apis\Controllers\getCode;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class getCodeRules extends index
{
    public static function rules (){
        
        $rules=[
            "apiToken"   =>"required",
            "discountCode"     =>"required|exists:stores,discountCode",
            "storeId"     =>"required|exists:stores,id",
        ];

        $messages=[
            "apiToken.required"     =>400,
            "apiToken.exists"       =>405,

            "discountCode.required"       =>400,
            "discountCode.exists"       =>405,

            "storeId.required"       =>400,
            "storeId.exists"         =>405,
        ];

        $messagesAr=[   
            "apiToken.required"     =>"يجب ادخال التوكن",
            "apiToken.exists"       =>"هذا التوكن غير موجود",

            "storeId.exists"         =>"هذا المتجر غير موجود",
            "storeId.required"         =>"يجب ادخال المتجر",

            "discountCode.required"         =>"يجب ادخال الكود ",
            "discountCode.exists"         =>"يجب ادخال الكود بشكل صحيح ",
        ];

        $messagesEn=[
        ];
        $ValidationFunction=self::$request->showAllErrors==1?"showAllErrors":"Validator";
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }

        return helper::validateAccount()??null;
    }
}
