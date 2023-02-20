<?php
namespace App\Http\Controllers\Apis\Controllers\deleteMessage;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class deleteMessageRules extends index
{
    public static function rules (){
        
        $rules=[
            "apiToken"   =>"required",
            "messageId"  =>"required|exists:messages,id",
        ];

        $messages=[
            "apiToken.required"     =>400,

            "messageId.required"    =>400,
            "messageId.exists"      =>405,
        ];

        $messagesAr=[   
            "apiToken.required"     =>"يجب ادخال التوكن",

            "messageId.exists"         =>"هذه الرسالة غير موجود",
            "messageId.required"       =>"يجب ادخال رقم الرسالة",
        ];

        $messagesEn=[
        ];
        $ValidationFunction=self::$request->showAllErrors==1?"showAllErrors":"Validator";
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }

        return helper::validateAccount()??null;
    }
}
