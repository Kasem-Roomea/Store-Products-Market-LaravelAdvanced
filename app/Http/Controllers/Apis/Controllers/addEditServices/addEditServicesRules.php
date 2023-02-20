<?php
namespace App\Http\Controllers\Apis\Controllers\addEditServices;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Helper\helper;

class addEditServicesRules extends index
{
    public static function rules (){
        
        $rules=[
            "apiToken"           =>"required|exists:providers,apiToken",
            "storeId"            =>"required|exists:stores,id",
            "services.*.id"      =>"required|exists:services,id",
            "services.*.price"   =>"required|numeric|min:0",
            "services.*.discount"=>"required|numeric",
        ];

        $messages=[
            "apiToken.required"     =>400,
            "apiToken.exists"       =>405,

            "services.required"         =>400,
            "services.array"            =>405,

            "storeId.required"         =>400,
            "storeId.exists"         =>405,

            "services.*.id.required"    =>400,
            "services.*.id.exists"      =>400,

            "services.*.price.required" =>400,
            "services.*.price.numeric" =>405,
            "services.*.price.min" =>405,

            "services.*.discount.required" =>400,
            "services.*.discount.numeric" =>405,
            "services.*.discount.min" =>405,
            "services.*.discount.max" =>405,
        ];

        $messagesAr=[   
            "apiToken.required"     =>"يجب ادخال التوكن",
            "apiToken.exists"       =>"هذا التوكن غير موجود",

            "services.required"        =>"يحب إدخال الخدمات",
            "services.array"           =>"يجب  إدخال البيانات علي شكل ارراي ",

            "storeId.required"         =>"يجب إدخال رقم المتجر",
            "storeId.exists"         =>"يجب إدخال رقم المتجر بشكل صحيح",
 
            "services.*.id.required"   =>"يجب إدخال رقم الخدمة في جميع الخدمات ",
            "services.*.exists"        =>"يجب إدخال رقم الخدمة في جميع الخدمات بشكل صحيح ",
      
            "services.*.price.required"=>"يجب إدخال السعر في جميع الخدمات",
            "services.*.price.numeric" =>"يجب إدخال السعر بشكل صحيح",
            "services.*.price.min"     =>"يجب إدخال السعر بشكل صحيح",

            "services.*.discount.required"=>"يجب إدخال الخصم في جميع الخدمات",
            "services.*.discount.numeric" =>"يجب إدخال الخصم بشكل صحيح",
            "services.*.discount.min"     =>"يجب إدخال الخصم بشكل صحيح",
            "services.*.discount.max"     =>"يجب إدخال الخصم بشكل صحيح",
        ];

        $messagesEn=[
        ];
        $ValidationFunction=self::$request->showAllErrors==1?"showAllErrors":"Validator";
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }
        if (self::$request->discount > self::$request->price){
            return [
                "status"=>405,
                "message"=>self::$lang=="ar"?"يجب أن يكون سعر الخصم اقل من السعر الاصلي":"discount must less than price"
            ];
        }
        return helper::validateAccount()??null;
    }
}