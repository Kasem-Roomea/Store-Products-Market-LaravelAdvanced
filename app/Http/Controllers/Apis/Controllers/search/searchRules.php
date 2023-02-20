<?php
namespace App\Http\Controllers\Apis\Controllers\search;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class searchRules extends index
{
    public static function rules (){
        
        $rules=[
            // "search"     =>"required",
            "type"      =>"required|in:product,store",
            "page"      =>"required|numeric"
        ];

        $messages=[
            "search.required"       =>400,

            "type.required"         =>400,
            "type.in"               =>405,

            "page.required"         =>400,
            "page.numeric"          =>405
        ];

        $messagesAr=[   
            "search.required"       =>"يجب ادخال كلمة البحث ",

            "type.required"         =>"يجب إدخال النوع",
            "type.in"         =>"يجب إدخال النوع بشكل صحيح",

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
