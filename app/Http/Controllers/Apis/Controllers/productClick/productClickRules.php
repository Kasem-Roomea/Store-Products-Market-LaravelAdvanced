<?php
namespace App\Http\Controllers\Apis\Controllers\productClick;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class productClickRules extends index
{
    public static function rules (){
        
        $rules=[
            "productId"     =>"required|exists:products,id",
            "device_id"     =>"required"
        ];

        $messages=[
            "device_id.required"       =>400,

            "productId.required"       =>400,
            "productId.exists"         =>405,
        ];

        $messagesAr=[   
            "productId.exists"         =>"هذا المنتج غير موجود",
            "productId.required"       =>"يجب ادخال رقم المنتج",

            "device_id.required"       =>"يجب ادخال رقم الجهاز",
        ];

        $messagesEn=[
        ];
        $ValidationFunction=self::$request->showAllErrors==1?"showAllErrors":"Validator";
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }

        return helper::validateAccount()??null;
    }
}
