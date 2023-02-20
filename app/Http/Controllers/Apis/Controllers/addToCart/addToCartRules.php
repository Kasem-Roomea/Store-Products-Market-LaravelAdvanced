<?php
namespace App\Http\Controllers\Apis\Controllers\addToCart;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class addToCartRules extends index
{
    public static function rules (){
        
        $rules=[
            "apiToken"   =>"required",
            "productId"      =>"required|exists:products,id",
            "priceId"      =>"exists:prices,id"
        ];

        $messages=[
            "apiToken.required"     =>400,
            "apiToken.exists"       =>405,

            "productId.required"         =>400,
            "productId.exists"          =>405,

            "priceId.exists"          =>405
        ];

        $messagesAr=[   
            "apiToken.required"     =>"يجب ادخال التوكن",
            "apiToken.exists"       =>"هذا التوكن غير موجود",

            "productId.required"         =>"يجب ادخال رقم المنتج",
            "productId.exists"          =>"يجب ادخال رقم المنتج بشكل صحيح",

            "priceId.exists"          =>"يجب ادخال رقم السعر بشكل صحيح",


        ];

        $messagesEn=[
        ];
        $ValidationFunction=self::$request->showAllErrors==1?"showAllErrors":"Validator";
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }

        return helper::validateAccount()??null;
    }
}
