<?php
namespace App\Http\Controllers\Apis\Controllers\refuseOrder;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class refuseOrderRules extends index
{
    public static function rules (){
        
        $rules=[
            "apiToken"   =>"required|exists:providers,apiToken",
            "orderId"     =>"required|exists:orders,id",
        ];

        $messages=[
            "apiToken.required"     =>400,
            "apiToken.exists"       =>405,

            "orderId.required"      =>400,
            "orderId.exists"        =>405,
        ];

        $messagesAr=[   
            "apiToken.required"     =>"يجب ادخال التوكن",
            "apiToken.exists"       =>"هذا التوكن غير موجود",

            "orderId.exists"        =>"هذا الطلب غير موجود",
            "orderId.required"      =>"يجب ادخال رقم الطلب",
        ];

        $messagesEn=[
        ];
        $ValidationFunction=self::$request->showAllErrors==1?"showAllErrors":"Validator";
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }

        return helper::validateAccount()??null;
    }
}
