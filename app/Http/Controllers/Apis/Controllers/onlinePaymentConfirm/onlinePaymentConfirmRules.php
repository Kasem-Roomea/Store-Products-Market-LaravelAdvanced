<?php
namespace App\Http\Controllers\Apis\Controllers\onlinePaymentConfirm;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class onlinePaymentConfirmRules extends index
{
    public static function rules (){
        
        $rules=[
            "orderId"     =>"required|exists:orders,id|exists:online_payment_confirm,orders_id",
        ];

        $messages=[
            "orderId.required"     =>400,
            "orderId.exists"       =>405,
        ];

        $messagesAr=[   
            "orderId.required"     =>"يجب ادخال رقم الطلب",
            "orderId.exists"       =>" رقم الطلب غير موجود او نوع الدفع في هذا الطلب ليس دفع الكترونياَ",
        ];

        $messagesEn=[
        ];
        $ValidationFunction=self::$request->showAllErrors==1?"showAllErrors":"Validator";
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="Ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }

        return helper::validateAccount()??null;
    }
}
