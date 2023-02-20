<?php
namespace App\Http\Controllers\Apis\Controllers\getProducts;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class getProductsRules extends index
{
    public static function rules ()
    {
        $rules=[
            "productId"=>"required|exists:products,id",
        ];

        $messages=[
            "productId.required"     =>400,
            "productId.exists"       =>405,
        ];

        $messagesAr=[   
            "productId.required"     =>"يجب ادخال المنتج",
            "productId.exists"       =>"هذا المنتج غير موجود",
        ];

        $messagesEn=[
        ];
        $ValidationFunction=self::$request->showAllErrors==1?"showAllErrors":"Validator";
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }

        return helper::validateAccount()??null;
    }
}
