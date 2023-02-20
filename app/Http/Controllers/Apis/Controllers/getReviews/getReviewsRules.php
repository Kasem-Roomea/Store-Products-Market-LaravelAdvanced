<?php
namespace App\Http\Controllers\Apis\Controllers\getReviews;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class getReviewsRules extends index
{
    public static function rules (){
        
        $rules=[
            "targetId"   =>"required",
            "type"      =>"in:shop,product,provider,user",
            "page"      =>"required|numeric"
        ];

        $messages=[
            "targetId.required" =>400,

            "type.in"           =>405,

            "page.required"     =>400,
            "page.numeric"      =>405
        ];

        $messagesAr=[   
            "targetId.required"       =>"يجب ادخال رقم التارجت",

            "type.in"                =>" shop & product & provider & userيجب أن يكون النوع ",
            
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
