<?php
namespace App\Http\Controllers\Apis\Controllers\addOffer;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class addOfferRules extends index
{
    public static function rules (){
        
        $rules=[
            "apiToken"   =>"required",
            "orderId"    =>"required|exists:orders,id",
            "price"      =>"required|numeric"
        ];

        $messages=[
            "apiToken.required"     =>400,
            "apiToken.exists"       =>405,

            "orderId.required"       =>400,
            "orderId.exists"         =>405,

            "price.required"         =>400,
            "price.numeric"          =>405
        ];

        $messagesAr=[   
            "apiToken.required"     =>"يجب ادخال التوكن",
            "apiToken.exists"       =>"هذا التوكن غير موجود",

            "orderId.exists"         =>"هذا الطلب غير موجود",
            "orderId.required"       =>"يجب ادخال رقم الطلب",

            "price.required"         =>"يجب ادخال السعر ",
            "price.numeric"          =>"يجب ادخال السعر بشكل صحيح",
        ];

        $messagesEn=[
        ];
        $ValidationFunction=self::$request->showAllErrors==1?"showAllErrors":"Validator";
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }

        return helper::validateAccount()??null;
    }
}
