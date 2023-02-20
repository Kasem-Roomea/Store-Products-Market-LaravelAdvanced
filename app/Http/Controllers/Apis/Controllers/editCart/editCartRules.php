<?php
namespace App\Http\Controllers\Apis\Controllers\editCart;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class editCartRules extends index
{
    public static function rules (){
        
        $rules=[
            "apiToken"   =>"required",
            "cartId"      =>"required|exists:carts,id",
            "quantity"   =>'required',
            "priceId"      =>"exists:prices,id"

        ];

        $messages=[
            "apiToken.required"     =>400,
            "apiToken.exists"       =>405,

            "cartId.required"         =>400,
            "cartId.exists"          =>405,

            "priceId.exists"          =>405,

            "quantity.required"         =>400,

        ];

        $messagesAr=[   
            "apiToken.required"     =>"يجب ادخال التوكن",
            "apiToken.exists"       =>"هذا التوكن غير موجود",

            "cartId.required"         =>"يجب ادخال رقم العربة",
            "cartId.exists"          =>"يجب ادخال رقم العربة بشكل صحيح",

            "quantity.required"         =>"يجب ادخال الكمية ",

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
