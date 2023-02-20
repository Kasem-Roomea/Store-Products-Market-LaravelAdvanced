<?php
namespace App\Http\Controllers\Apis\Controllers\socialLinks;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class socialLinksRules extends index
{
    public static function rules (){
        
        $rules=[
            "apiToken"   =>"exists:users,apiToken",
            "userId"     =>"exists:users,id",
            "shopId"     =>"exists:users,id",
            "providerId"     =>"exists:users,id",
            "appInfoId"     =>"exists:users,id",
        ];

        $messages=[
            "apiToken.exists"       =>405,

            "userId.exists"       =>405,

            "shopId.exists"       =>405,

            "providerId.exists"       =>405,

            "appInfoId.exists"       =>405,
        ];

        $messagesAr=[   
            "apiToken.exists"       =>"هذا التوكن غير موجود",

            "userId.exists"         =>"هذا الشخص غير موجود",

            "providerId.exists"         =>"هذا الشخص غير موجود",

            "shopId.exists"         =>"هذا المحل غير موجود",

            "appInfoId.exists"         =>" رقم عدادات غير صحصح غير موجود",

        ];

        $messagesEn=[
        ];
        $ValidationFunction=self::$request->showAllErrors==1?"showAllErrors":"Validator";
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }

        return helper::validateAccount()??null;
    }
}
