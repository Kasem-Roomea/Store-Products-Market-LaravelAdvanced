<?php
namespace App\Http\Controllers\Apis\Controllers\cancelOffer;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class cancelOfferRules extends index
{
    public static function rules (){
        
        $rules=[
            "apiToken"   =>"required",
            "offerId"    =>"required|exists:offers,id",
            "resonId"    =>"exists:reason_to_cancel,id",
        ];

        $messages=[
            "apiToken.required"     =>400,
            "apiToken.exists"       =>405,

            "offerId.required"       =>400,
            "offerId.exists"         =>405,
           
            "resonId.exists"         =>405,
        ];

        $messagesAr=[   
            "apiToken.required"     =>"يجب ادخال التوكن",
            "apiToken.exists"       =>"هذا التوكن غير موجود",

            "offerId.exists"         =>"هذا العرض غير موجود",
            "offerId.required"       =>"يجب ادخال رقم العرض",
       
            "resonId.exists"         =>"رقم سبب الإلغاء غير موجود",
        ];

        $messagesEn=[
        ];
        $ValidationFunction=self::$request->showAllErrors==1?"showAllErrors":"Validator";
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }
        return helper::validateAccount()??null;
    }
}