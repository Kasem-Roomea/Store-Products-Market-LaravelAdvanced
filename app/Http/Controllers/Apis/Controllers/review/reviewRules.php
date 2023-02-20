<?php
namespace App\Http\Controllers\Apis\Controllers\review;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class reviewRules extends index
{
    public static function rules (){
        
        $rules=[
            "apiToken"   =>"required",
            "targetId"   =>"required",
            "comment"    =>"string",
            "type"       =>"required",
            "orderId"    =>"exists:orders,id",
            "rating"     =>"required|in:bad,good,excellent"
        ];

        $messages=[
            "apiToken.required"     =>400,
            "apiToken.exists"       =>405,

            "targetId.required"     =>400,

            "type.required"         =>400,
            
            "orderId.exists"        =>405,

            "rating.required"       =>400,
            "rating.in"             =>405,
        ];

        $messagesAr=[   
            "apiToken.required"     =>"يجب ادخال التوكن",
            "apiToken.exists"       =>"هذا التوكن غير موجود",

            "type.required"         =>"يجب إدخال النوع",
            "type.in"               =>"يجب إدخال النوع",

            "targetId.required"     =>"يجب ادخال رقم التارجت",
        
            "orderId.exists"        =>"رقم الطلب غير موجود",
        
            "rating.required"       =>"يجب إدخال التقييم ",
            "rating.in"             =>"bad , good , excellent يجب ان يكون التقييم ",
        ];

        $messagesEn=[
        ];
        $ValidationFunction=self::$request->showAllErrors==1?"showAllErrors":"Validator";
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }

        return helper::validateAccount()??null;
    }
}
