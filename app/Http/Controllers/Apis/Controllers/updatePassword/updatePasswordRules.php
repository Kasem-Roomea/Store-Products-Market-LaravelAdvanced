<?php

namespace App\Http\Controllers\Apis\Controllers\updatePassword;
use  App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\sessions;
use App\Http\Controllers\Apis\Helper\helper ;

class updatePasswordRules extends index
{
    public static function rules (){
        
        $rules=[
            "apiToken"=>"required",
            "oldPassword" =>"required|string|min:6",
            "newPassword" =>"required|string|min:6",
        ];

        $messages=[
            "apiToken.required"    =>400,

            "oldPassword.required" =>405,
            "oldPassword.min"      =>405,

            "newPassword.required" =>405,
            "newPassword.min"      =>405,
        ];

        $messagesAr=[   
            "apiToken.required"   =>"يجب ادخال التوكن الخاص بالمستخدم",

            "oldPassword.required"=>"يجب ادخال الرقم السري القديم",
            "oldPassword.min"     =>"يجب ان لا يقل الرقم السري عن 6 ارقام او حروف",

            "newPassword.required"=>"يجب ادخال الرقم السري الجديد",
            "newPassword.min"     =>"يجب ان لا يقل الرقم السري عن 6 ارقام او حروف",

        ];

        $messagesEn=[
            
        ];
        $ValidationFunction=self::$request->showAllErrors==1?'showAllErrors':'Validator';
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }

        return helper::validateAccount()??null; 
    }
}
