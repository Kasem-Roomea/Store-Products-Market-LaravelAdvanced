<?php
namespace App\Http\Controllers\Apis\Controllers\getOrders;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class getOrdersRules extends index
{
    public static function rules (){
        
        $rules=[
            "apiToken"   =>"required",
            'status'     =>"array",
            'status.*'   =>"in:waiting,accept,finished,cancel,sentToDeliveries,acceptedByStore,acceptedByDriver",
            'totalPrice'=>"numeric",
            "date"      =>"date",
            "orderId"   =>"exists:orders,id",
            "page"      =>"required|numeric"
        ];

        $messages=[
            "apiToken.required"     =>400,
            "apiToken.exists"       =>405,

            "status.array"          =>405,
            "status.*.in"           =>405,

            "totalPrice.numeric"    =>405,

            "orderId.exists"        =>405,

            "date.date"             =>405,

            "page.required"         =>400,
            "page.numeric"          =>405
        ];

        $messagesAr=[   
            "apiToken.required"     =>"يجب ادخال التوكن",
            "apiToken.exists"       =>"هذا التوكن غير موجود",

            "status.array"          =>"يجب إدخال الحالة عبارة عن ارراي ",
            "status.*.in"             =>"  waiting,accepted,finished,cancelled : في تحديد النوع يجب ان يكون  :",

            "orderId.exists"        =>"رقم الطلب غير موجود",

            "totalPrice.numeric"    =>"يجب تحديد اجمالي السعر بشكل صحيح",

            "date.date"             =>"يجب تحديد التاريخ بشكل صحيح مثل :  00:00:00  2019-12-12 أو  2019-12-12 ",

            "page.required"         =>"يجب ادخال رقم الصفحة",
            "page.numeric"          =>"يجب ادخال رقم الصفحة بشكل صحيح",
        ];

        $messagesEn=[
        ];
        $ValidationFunction=self::$request->showAllErrors==1?"showAllErrors":"Validator";
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }

        return helper::validateAccount()??null;
    }
}
