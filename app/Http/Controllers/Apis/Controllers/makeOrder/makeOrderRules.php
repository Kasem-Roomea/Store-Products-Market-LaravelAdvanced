<?php
namespace App\Http\Controllers\Apis\Controllers\makeOrder;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class makeOrderRules extends index
{
    public static function rules ()
    {
        $rules=[
            "apiToken"               =>"required",
            
            "priceId"               =>"exists:prices,id",
            
            "orderLocation"          =>"required",
            "orderLocation.longitude"=>"required",
            "orderLocation.latitude" =>"required",
            "orderLocation.address"  =>"required",
            
            "discountCode"           =>"exists:stores,discountCode",

            "paymentMethod"          =>"required|in:Cash,visa,myCredit,points",
            
            "deliveryTime"           =>"required|date_format:Y-m-d",

            "PaymentId" =>"required_if:paymentMethod,visa"

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
            
            "priceId.exists"    =>405, 

            "PaymentId.required_if"                  =>400,

        ];

        $messagesAr=[   
            "apiToken.required"                  =>"يجب ادخال التوكن",
            "apiToken.exists"                    =>"هذا التوكن غير موجود",


            "orderLocation.required"            =>"يجب إدخال عنوان المنتج",
            "orderLocation.required.*"          =>"longitude & latitude & address يجب إدخال عنوان الطلب بشكل صحيح  ",
            
            "discountCode.in"                  =>"هذا الكود غير موجود",
            "discountCode.exists"                  =>"هذا الكود غير موجود",

            "paymentMethod.required"            =>"يجب إدخال نوع طريقة الدفع ",
            "paymentMethod.in"                  =>"يجب إدخال نوع طريقة الدفع بشكل صيح",
            
            "deliveryTime.required"             =>"يجب إدخال وقت التوصيل",
            "deliveryTime.date_format"          =>" Y-m-d يجب إدخال وقت التوصيل بشكل صحيح ",

            "priceId.exists"                  =>" كود السعر غير موجود",

            "PaymentId.required_if"                  =>"يجب ادخال PaymentId",


        ];
        $messagesEn=[
        ];
        $ValidationFunction=self::$request->showAllErrors==1?"showAllErrors":"Validator";
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="Ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }

        return helper::validateAccount()??null;
    }
}
