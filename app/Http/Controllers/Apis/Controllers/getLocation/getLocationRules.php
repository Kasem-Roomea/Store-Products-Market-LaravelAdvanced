<?php
namespace App\Http\Controllers\Apis\Controllers\getLocation;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class getLocationRules extends index
{
    public static function rules (){
        
        $rules=[
            "apiToken"   =>"required",
            // "targetId"   =>"required",
            // "type"      =>"in:store,driver,user",
        ];

        $messages=[
            "apiToken.required" =>400,
            "apiToken.exists"   =>405,

            "targetId.required" =>400,

            "type.in"           =>405,

        ];

        $messagesAr=[   
            "apiToken.required"     =>"يجب ادخال التوكن",
            "apiToken.exists"       =>"هذا التوكن غير موجود",

            "targetId.required"       =>"يجب ادخال رقم التارجت",

            "type.in"                =>" user & driver & store & userيجب أن يكون النوع ",
        ];

        $messagesEn=[
        ];
        $ValidationFunction=self::$request->showAllErrors==1?"showAllErrors":"Validator";
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }

        return helper::validateAccount()??null;
    }
}
