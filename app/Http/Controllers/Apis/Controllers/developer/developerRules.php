<?php
namespace App\Http\Controllers\Apis\Controllers\developer;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class developerRules extends index
{
    public static function rules (){
        
        $rules=[
            "objects"     =>"nullable",
            "type"      =>"in:user,provider",
            'page'      =>"numeric"
        ];

        $messages=[
            "type.in"            =>400,
            "page.numeric"       =>405
        ];

        $messagesAr=[   
            "type.in"            =>" [user,provider] خطأ في إدخال نوع الابليكيشن ",
            "page.numeric"       =>"يجب إدخال رقم الصفحة بشكل صحيح"
        ];

        $messagesEn=[
        ];
        $ValidationFunction=self::$request->showAllErrors==1?"showAllErrors":"Validator";
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }

        return helper::validateAccount()??null;
    }
}