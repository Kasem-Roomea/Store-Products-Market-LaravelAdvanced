<?php
namespace App\Http\Controllers\Apis\Controllers\adClick;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class adClickRules extends index
{
    public static function rules (){
        
        $rules=[
            "addId"     =>"required|exists:ads,id",
        ];

        $messages=[
            "addId.required"       =>400,
            "addId.exists"         =>405,
        ];

        $messagesAr=[   
            "addId.exists"         =>"هذا الإعلان غير موجود",
            "addId.required"       =>"يجب ادخال رقم الإعلان",
        ];

        $messagesEn=[
        ];
        $ValidationFunction=self::$request->showAllErrors==1?"showAllErrors":"Validator";
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }

        return helper::validateAccount()??null;
    }
}
