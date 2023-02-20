<?php
namespace App\Http\Controllers\Apis\Controllers\checkDistanceToMakeOrder;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class checkDistanceToMakeOrderRules extends index
{
    public static function rules ()
    {
        $rules=[
            "apiToken"               =>"required",
            
            "orderLocation"          =>"required",
            "orderLocation.longitude"=>"required",
            "orderLocation.latitude" =>"required",
            "orderLocation.address"  =>"required",
            

        ];

        $messages=[
            "apiToken.required"                  =>400,
            "apiToken.exists"                    =>405,

            "orderLocation.required"            =>400,
            "orderLocation.required.longitude"  =>400,
            "orderLocation.required.latitude"   =>400,
            "orderLocation.required.address"    =>400,
            
            "discountCode.in"                   =>405,
            "discountCode.exists"               =>405,

            "paymentMethod.required"            =>400,
            "paymentMethod.in"                  =>400,
            
            "deliveryTime.required"             =>400,
            "deliveryTime.date_format"          =>400,
            
            "carts.*.features"       => 405,
            "carts.*.features.*.required"  => 400,
            "carts.*.features.*.exists"  => 405,
        ];

        $messagesAr=[   
            "apiToken.required"                  =>"يجب ادخال التوكن",
            "apiToken.exists"                    =>"هذا التوكن غير موجود",

            "carts.required"                     =>"يجب إدخال المنتجات عبارة عن ارراي ",
            "carts.array"                        =>"يجب إدخال المنتجات عبارة عن ارراي ",
            "carts.*.productId.required"                  =>"يجب إدخال رقم المنتج",
            "carts.*.productId.exists"        =>"رقم المنتج غير موجود",

            "carts.*.quantity.required"                   =>"يجب إدخال الكمية المطلوبة",

            "orderLocation.required"            =>"يجب إدخال عنوان المنتج",
            "orderLocation.required.*"          =>"longitude & latitude & address يجب إدخال عنوان الطلب بشكل صحيح  ",
            
            "discountCode.in"                  =>"هذا الكود غير موجود",
            "discountCode.exists"                  =>"هذا الكود غير موجود",

            "paymentMethod.required"            =>"يجب إدخال نوع طريقة الدفع ",
            "paymentMethod.in"                  =>"يجب إدخال نوع طريقة الدفع بشكل صيح",
            
            "deliveryTime.required"             =>"يجب إدخال وقت التوصيل",
            "deliveryTime.date_format"          =>" Y-m-d يجب إدخال وقت التوصيل بشكل صحيح ",

            "carts.*.features"       => "يجب إن تكون الاضافات عبارة عن ارراي",
            "carts.*.features.*.required"  => "يجب إدخال رقم الاضافة في كل الاضافات الموجودة داخل الكارت",
            "carts.*.features.*.exists"  => "يجب إدخال رقم الاضافة في كل الاضافات الموجودة داخل الكارت بشكل صحيح",
       ];
        $messagesEn=[
        ];
        $ValidationFunction=self::$request->showAllErrors==1?"showAllErrors":"Validator";
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="Ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }

        return helper::validateAccount()??null;
    }
}
