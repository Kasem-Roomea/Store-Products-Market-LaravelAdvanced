<?php
namespace App\Http\Controllers\Apis\Controllers\chooseDeliveryLocation;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Models\myAddress;

class chooseDeliveryLocationRules extends index
{
    public static function rules (){
        

        $rules=[
            "apiToken"   =>"required",
            "locationId"     =>"required|exists:myAddress,id",
        ];

        $messages=[
            "apiToken.required"     =>400,
            "apiToken.exists"       =>405,

            "locationId.required"       =>400,
            "locationId.exists"         =>405,
        ];

        $messagesAr=[   
            "apiToken.required"     =>"يجب ادخال التوكن",
            "apiToken.exists"       =>"هذا التوكن غير موجود",

            "locationId.exists"         =>"رقم اللوكيشن غير موجود",
            "locationId.required"       =>"يجب ادخال رقم اللوكيشن",
        ];

        $messagesEn=[
        ];
        $ValidationFunction=self::$request->showAllErrors==1?"showAllErrors":"Validator";
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }

        return helper::validateAccount()??null;
    }
}
