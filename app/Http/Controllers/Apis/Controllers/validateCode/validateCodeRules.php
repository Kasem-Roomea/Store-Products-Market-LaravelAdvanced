<?php

namespace App\Http\Controllers\Apis\Controllers\validateCode;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper ;
use Illuminate\Support\Str;

class validateCodeRules extends index
{    

    public static function rules (){

        $rules=[
            "phone" => 'required_without_all:apiToken,tmpToken|numeric|between:100000000,99999999999999999999',
            "apiToken" => 'required_without_all:phone,tmpToken',
            "tmpToken" => 'required_without_all:phone,apiToken|exists:sessions,tmpToken',
            "code" => 'required|numeric|between:1000,9999',
        ];

        $messages=[
            "phone.between"       =>405,
            'required_without_all'=>400,
            
            "tmpToken.exists"     =>405,
            
            "code.required"       =>400,
            "code.numeric"        =>405,
            "code.between"        =>405,
            "code.exists"         =>410 ,
        ];

        $messagesAr=[

            "phone.nemeric"       =>"يجب ادخال رقم التليفون بشكل صحيح ",
            "phone.between"       =>"يجب ان لا يقل رقم التليفون عن 11 ارقام ولا يزيد عن 15 رقم ",
           
            'required_without_all'=>"يجب ادخال رقم التليفون او التوكن او التيمب توكن لاستكمال العملية",

            "tmpToken.exists"     =>"تيمب توكن غير صحيح",

            "code.required"       =>"يجب ادخال الكود",
            "code.numeric"       =>"يجب ادخال الكود بشكل صحيح",
            "code.between"       =>"يجب ان يكون الكود مكون من 4 أرقام",
        ];

        $messagesEn=[
            "code.exists"       =>"wrong code or expired",

            
        ];
        $ValidationFunction=self::$request->showAllErrors==1?'showAllErrors':'Validator';
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }

        if(self::$account == null )
            return [
                'status'=>403,
                'message'=>self::$lang=='ar'?'لا يوجد حساب بهذه المعلومات': 'no account with this information'
            ];

            elseif(self::$account->deletedAt!= null)
            return [
                'status'=>403,
                'message'=>self::$lang=='ar'?'تم مسح هذا الحساب ': 'this account has been deleted'
            ];
       
        elseif(self::$account->isActive== 0)
            return [
                'status'=>403,
                'message'=>self::$lang=='ar'?'تم الغاء تنشيط هذا الحساب': 'this account has been deactivate'
            ];
        elseif(self::$account->session== null)
            return [
                'status'=>406,
                'message'=>self::$lang=='ar'?'لا يمكن عمل هذا الان  يوجد خطوة قبل عمل تحقق من الكود': 'you can\'t do this step now ,you should do a step before validation'
            ];
            if(self::$account->session->code != self::$request->code )
            return [
                'status'=>410,
                'message'=>self::$lang=='ar'?'رمز النحقق خاطئ': 'Wrong verification code'
            ];

    }

}
