<?php
namespace App\Http\Controllers\Apis\Controllers\contactUs;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class contactUsRules extends index
{
    public static function rules (){
        
        $rules=[
            "apiToken"   =>"exists:users,apiToken",
            "orderId"    =>"exists:orders,id",
            "title"      =>"min:3",
            "message"    =>"min:3",
        ];

        $messages=[
            "apiToken.required"     =>400,
            "apiToken.exists"       =>405,

            "orderId.exists"        =>405,  

            "title.min"             =>405,

            "message.min"           =>405,
        ];

        $messagesAr=[   
            "apiToken.required"     =>"يجب ادخال التوكن",
            "apiToken.exists"       =>"هذا التوكن غير موجود",

            "orderId.exists"        =>"رقم الطلب غير موجود",  

            "title.min"             =>"يجب ان لا يقل العنوان عن 3 حروف",

            "message.min"           =>"يجب ان لا تقل الرسالة عن 3 حروف",
        ];

        $messagesEn=[
        ];
        $ValidationFunction=self::$request->showAllErrors==1?"showAllErrors":"Validator";
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,
        
        self::$lang=="ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }

        return helper::validateAccount()??null;
    }
}
