<?php
namespace App\Http\Controllers\Apis\Controllers\editOfferPrice;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class editOfferPriceRules extends index
{
    public static function rules (){
        
        $rules=[
            "apiToken"   =>"required",
            "offerId"    =>"required|exists:offers,id",
            "price"      =>"required|numeric"
        ];

        $messages=[
            "apiToken.required"     =>400,
            "apiToken.exists"       =>405,

            "offerId.required"       =>400,
            "offerId.exists"         =>405,

            "price.required"         =>400,
            "price.numeric"          =>405
        ];

        $messagesAr=[   
            "apiToken.required"     =>"يجب ادخال التوكن",
            "apiToken.exists"       =>"هذا التوكن غير موجود",

            "offerId.exists"         =>"هذا العرض غير موجود",
            "offerId.required"       =>"يجب ادخال رقم العرض",

            "price.required"         =>"يجب ادخال السعر",
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
