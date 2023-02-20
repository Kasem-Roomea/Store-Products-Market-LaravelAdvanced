<?php
namespace App\Http\Controllers\Apis\Controllers\deleteService;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class deleteServiceRules extends index
{
    public static function rules (){
        
        $rules=[
            "apiToken"   =>"required|exists:providers,apiToken",
            "serviceId"  =>"required|exists:services_in_store,services_id",
        ];

        $messages=[
            "apiToken.required"     =>400,
            "apiToken.exists"       =>405,

            "serviceId.required"    =>400,
            "serviceId.exists"      =>405,
        ];

        $messagesAr=[   
            "apiToken.required"     =>"يجب ادخال التوكن",
            "apiToken.exists"       =>"هذا التوكن غير موجود",

            "serviceId.exists"      =>"هذه الخدمة غير موجودة",
            "serviceId.required"    =>"يجب ادخال رقم الخدمة",
        ];

        $messagesEn=[
        ];
        $ValidationFunction=self::$request->showAllErrors==1?"showAllErrors":"Validator";
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }
        return helper::validateAccount()??null;
    }
}