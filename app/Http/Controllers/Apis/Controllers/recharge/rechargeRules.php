<?php
namespace App\Http\Controllers\Apis\Controllers\recharge;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class rechargeRules extends index
{
    public static function rules (){
        
        $rules=[
            "apiToken"   =>"required",
            "amount"     =>"",
            "image"      =>"required"
        ];

        $messages=[
            "apiToken.required"     =>400,

            "image.required"         =>400,
        ];

        $messagesAr=[   
            "apiToken.required"     =>"يجب ادخال التوكن",

            "image.required"        =>"يجب ادخال الصورة",
        ];

        $messagesEn=[
        ];
        $ValidationFunction=self::$request->showAllErrors==1?"showAllErrors":"Validator";
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }

        return helper::validateAccount()??null;
    }
}
