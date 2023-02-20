<?php
namespace App\Http\Controllers\Apis\Controllers\deleteAddress;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class deleteAddressRules extends index
{
    public static function rules (){
        
        $rules=[
            "apiToken"   =>"required",
            "locationId" =>"required|exists:myAddress,id",
            // "type"       =>"required|in:user,provider"
        ];

        $messages=[
            "apiToken.required"     =>400,
            "apiToken.exists"       =>405,

            "locationId.required"   =>400,
            "locationId.exists"     =>405,

            "type.required"         =>400,
            "type.in"               =>405
        ];

        $messagesAr=[   
            "apiToken.required"     =>"يجب ادخال التوكن",
            "apiToken.exists"       =>"هذا التوكن غير موجود",

            "locationId.exists"     =>"هذا اللوكيشن غير موجود",
            "locationId.required"   =>"يجب ادخال رقم اللوكيشن",

            "type.required"         =>"يجب ادخال  الصفحة",
            "type.numeric"          =>"يجب ادخال رقم الصفحة بشكل صحيح",
        ];

        $messagesEn=[
        ];
        $ValidationFunction=self::$request->showAllErrors==1?"showAllErrors":"Validator";
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }

        return helper::validateAccount()??null;
    }
}
