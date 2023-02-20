<?php
namespace App\Http\Controllers\Apis\Controllers\addBill;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class addBillRules extends index
{
    public static function rules (){
        
        $rules=[
            "apiToken"   =>"required",
            "offerId"    =>"required|exists:offers,id",
            "cost"      =>"required|numeric",
            "image"     =>"required"
        ];

        $messages=[
            "apiToken.required"     =>400,
            "apiToken.exists"       =>405,

            "offerId.required"       =>400,
            "offerId.exists"         =>405,

            "cost.required"         =>400,
            "cost.numeric"          =>405,

            "image.required"        =>400
        ];

        $messagesAr=[   
            "apiToken.required"     =>"يجب ادخال التوكن",
            "apiToken.exists"       =>"هذا التوكن غير موجود",

            "offerId.exists"         =>"هذا العرض غير موجود",
            "offerId.required"       =>"يجب ادخال رقم العرض",

            "cost.required"         =>"يجب ادخال السعر",
            "cost.numeric"          =>"يجب ادخال السعر بشكل صحيح",

            "image.required"     =>"يجب ادخال الصورة",
        ];

        $messagesEn=[
        ];
        $ValidationFunction=self::$request->showAllErrors==1?"showAllErrors":"Validator";
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }

        return helper::validateAccount()??null;
    }
}
