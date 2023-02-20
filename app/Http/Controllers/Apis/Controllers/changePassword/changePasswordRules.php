<?php

namespace App\Http\Controllers\Apis\Controllers\changePassword;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper ;
class changePasswordRules extends index
{  
    public static function rules (){
        
        $rules=[
            "tmpToken"    =>"required|exists:sessions,tmp_token",
            "newPassword" =>"required|string|min:6",
        ];

        $messages=[
            "tmpToken.required"    =>400,
            "tmpToken.exists"      =>405,

            "newPassword.required" =>405,
            "newPassword.min"      =>405,
        ];

        $messagesAr=[   
            "tmpToken.required"   =>"يجب ادخال التيمب توكن",
            "tmpToken.exists"     =>"تيمب توكن غير صحيح ",

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

