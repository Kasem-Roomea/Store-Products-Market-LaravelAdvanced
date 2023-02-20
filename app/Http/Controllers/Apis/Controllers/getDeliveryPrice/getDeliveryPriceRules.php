<?php
namespace App\Http\Controllers\Apis\Controllers\getDeliveryPrice;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class getDeliveryPriceRules extends index
{
    public static function rules (){
        
        $rules=[
            "apiToken"   =>"required",
            "storeId"   =>"required|exists:stores,id",
            "location"   =>'required',
            "location.longitude"   =>'required',
            "location.latitude"   =>'required',
        ];

        $messages=[
            "apiToken.required"     =>400,
            "apiToken.exists"       =>405,

            "storeId.required"     =>400,
            "storeId.exists"       =>405,

            "location.required"     =>400,
            "location.longitude.required"     =>400,
            "location.latitude.required"     =>400,


        ];

        $messagesAr=[   
            "apiToken.required"     =>"يجب ادخال التوكن",
            "apiToken.exists"       =>"هذا التوكن غير موجود",
        ];

        $messagesEn=[
        ];
        $ValidationFunction=self::$request->showAllErrors==1?"showAllErrors":"Validator";
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }

        return helper::validateAccount()??null;
    }
}
