<?php
namespace App\Http\Controllers\Apis\Controllers\deleteNotification;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class deleteNotificationRules extends index
{
    public static function rules (){
        
        $rules=[
            "apiToken"      =>"required",
            "notificationId"=>"required|exists:notify,id",
        ];

        $messages=[
            "apiToken.required"     =>400,
            "apiToken.exists"       =>405,

            "notificationId.required" =>400,
            "notificationId.exists"   =>405,
        ];

        $messagesAr=[   
            "apiToken.required"     =>"يجب ادخال التوكن",
            "apiToken.exists"       =>"هذا التوكن غير موجود",

            "notificationId.exists"         =>"هذا الاشعار غير موجود",
            "notificationId.required"       =>"يجب ادخال رقم الاشعار",

        ];

        $messagesEn=[
        ];
        $ValidationFunction=self::$request->showAllErrors==1?"showAllErrors":"Validator";
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }

        return helper::validateAccount()??null;
    }
}
