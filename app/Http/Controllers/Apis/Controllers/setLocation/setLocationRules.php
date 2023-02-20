<?php
namespace App\Http\Controllers\Apis\Controllers\setLocation;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class setLocationRules extends index
{
    public static function rules (){
        
        $rules=[
            "apiToken"            =>"required",
            'location.longitude'  =>"required",
            'location.latitude'   =>"required",
            'location.address'   =>"required",
            "orderId"             =>"exists:orders,id"
        ];

        $messages=[
            "apiToken.required"     =>400,
            "apiToken.exists"       =>405,

            "location.*.required"   =>400,
            
            "orderId.exists"        =>405
        ];

        $messagesAr=[   
            "apiToken.required"     =>"يجب ادخال التوكن",
            "apiToken.exists"       =>"هذا التوكن غير موجود",

            "location.*.required"   =>" longitude & latitude & address يجب إدخال ",

            "orderId.exists"       =>"رقم الطلب غير موجود",
        ];

        $messagesEn=[
        ];
        $ValidationFunction=self::$request->showAllErrors==1?"showAllErrors":"Validator";
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }

        return helper::validateAccount()??null;
    }
}
