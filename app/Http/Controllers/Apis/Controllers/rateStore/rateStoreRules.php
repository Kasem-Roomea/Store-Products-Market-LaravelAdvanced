<?php
namespace App\Http\Controllers\Apis\Controllers\rateStore;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class rateStoreRules extends index
{
    public static function rules (){
        
        $rules=[
            "apiToken"   =>"required",
            "storeId"    =>"required|exists:stores,id",
            "rate"       =>"required|numeric|min:1|max:5",
            "comment"    =>"nullable"
        ];

        $messages=[
            "apiToken.required"     =>400,
            "apiToken.exists"       =>405,

            "storeId.required"      =>400,
            "storeId.exists"        =>405,

            "rate.required"        =>405,
            "rate.numeric"        =>405,
            "rate.min"             =>405,
            "rate.max"             =>405,

        ];

        $messagesAr=[   
            "apiToken.required"     =>"يجب ادخال التوكن",
            "apiToken.exists"       =>"هذا التوكن غير موجود",

            "storeId.exists"         =>"رقم المتجر غير موجود",
            "storeId.required"       =>"يجب ادخال رقم المتجر",
           
            "rate.required"        =>"يجب ادخال عدد النجوم  ",
            "rate.numerice"        =>"يجب ادخال عدد النجوم بشكل صحيح",
            "rate.min"             =>"يجب  ان لا يقل عدد النجوم عن 1 ",
            "rate.max"             =>"يجب  ان لا يزيد عدد النجوم عن 5 ",
];

        $messagesEn=[
        ];
        $ValidationFunction=self::$request->showAllErrors==1?"showAllErrors":"Validator";
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }

        return helper::validateAccount()??null;
    }
}
