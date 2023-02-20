<?php
namespace App\Http\Controllers\Apis\Controllers\withdrawRequests;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class withdrawRequestsRules extends index
{
    public static function rules (){
        
        $rules=[
            "apiToken"     =>"required",
            "smartWallet"  =>"required",
            "email"        =>"required"
        ];

        $messages=[
            "apiToken.required"     =>400,
            "apiToken.exists"       =>405,

            "smartWallet.required"  =>400,

            "email.required"        =>400,
        ];

        $messagesAr=[   
            "apiToken.required"     =>"يجب ادخال التوكن",
            "apiToken.exists"       =>"هذا التوكن غير موجود",

            "smartWallet.required"  =>"يجب ادخال رقم الحساب",

            "email.required"        =>"يجب ادخال البريد الالكتروني ",
        ];

        $messagesEn=[
        ];
        $ValidationFunction=self::$request->showAllErrors==1?"showAllErrors":"Validator";
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }

        return helper::validateAccount()??null;
    }
}
