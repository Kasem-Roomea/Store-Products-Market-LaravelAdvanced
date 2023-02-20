<?php
namespace App\Http\Controllers\Apis\Controllers\getAds;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class getAdsRules extends index
{
    public static function rules ()
    {
        $rules=[
            // "apiToken"  =>"required",
            "page"       =>"required|numeric",
            "type"       =>"required|in:welcome,offer,category,store",
            "productId"  =>"required_if:type,product|exists:products,id",
            "storeId"    =>"required_if:type,store|exists:stores,id",
        ];

        $messages=[
            "page.required"          =>400, 
            "page.numeric"           =>405, 

            "type.required"          =>400, 
            "type.in"                =>405, 

            "productId.required_if"  =>400,
            "productId.exists"       =>405,
         
            "storeId.required_if"  =>400,
            "storeId.exists"       =>405,
        ];

        $messagesAr=[   
            "page.required"         =>"يجب ادخال رقم الصفحة",
            "page.numeric"          =>"يجب ادخال رقم الصفحة بشكل صحيح",

            "type.required"         =>"يجب ادخال النوع ",
            "type.in"               =>"welcome,offer,category,store يجب ادخال النوع بشكل صحيح  ",

            "productId.required_if"         =>"يجب ادخال رقم المنتج",
            "productId.exists"         =>"يجب ادخال رقم المنتج بشكل صحيح",

            "storeId.required_if"         =>"يجب ادخال رقم المتجر",
            "storeId.exists"         =>"يجب ادخال رقم المتجر بشكل صحيح",
        ];

        $messagesEn=[
        ];
        $ValidationFunction=self::$request->showAllErrors==1?"showAllErrors":"Validator";
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }
        return helper::validateAccount()??null;
    }
}