<?php
namespace App\Http\Controllers\Apis\Controllers\getProfile;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper ;

class getProfileRules extends index
{
    public static function rules (){
        
        $rules=[
            "apiToken"   =>"required",
            "userId"     =>"required_if:providerId,|exists:users,id",
            "providerId" =>"required_if:userId,|exists:providers,id",
        ];
        $messages=[
            "apiToken.required"     =>400,
            "apiToken.exists"       =>405,

            "userId.required"       =>400,
            "userId.exists"         =>405,

            "required_if"           =>400,

            "providerId.required"   =>400,
            "providerId.exists"     =>405,
        ];
        $messagesAr=[   
            "apiToken.required"     =>"يجب ادخال التوكن",
            "apiToken.exists"       =>"هذا التوكن غير موجود",

            "userId.exists"         =>"هذا الرقم غير موجود",

            "required_if"           =>"يجب إدخال رقم الشخص او رقم مزود الخدمة",
            
            "providerId.exists"     =>"هذا الرقم غير موجود",
        ];
        $messagesEn=[];
        $ValidationFunction=self::$request->showAllErrors==1?"showAllErrors":"Validator";
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }
        return helper::validateAccount()??null;
    }
}