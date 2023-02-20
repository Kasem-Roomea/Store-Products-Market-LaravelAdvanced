<?php
namespace App\Http\Controllers\Apis\Controllers\addFavourite;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class addFavouriteRules extends index
{
    public static function rules (){
        
        $rules=[
            "apiToken"   =>"required",
            "storeId"     =>"required|exists:stores,id",
        ];

        $messages=[
            "apiToken.required"     =>400,
            "apiToken.exists"       =>405,

            "storeId.required"      =>400,
            "storeId.exists"        =>405,

        ];

        $messagesAr=[   
            "apiToken.required"     =>"يجب ادخال التوكن",
            "apiToken.exists"       =>"هذا التوكن غير موجود",

            "storeId.exists"         =>"رقم المتجر غير موجود",
            "storeId.required"       =>"يجب ادخال رقم المتجر",
        ];

        $messagesEn=[
        ];
        $ValidationFunction=self::$request->showAllErrors==1?"showAllErrors":"Validator";
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }

        return helper::validateAccount()??null;
    }
}
