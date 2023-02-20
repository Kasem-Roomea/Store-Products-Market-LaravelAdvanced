<?php
namespace App\Http\Controllers\Apis\Controllers\getServices;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class getServicesRules extends index
{
    public static function rules (){
        
        $rules=[
            "apiToken"    =>"required",
            "storeId"     =>"required_if:categoryId,|exists:stores,id",
            "categoryId"  =>"required_if:storeId,|exists:categories,id",
            "page"        =>"required|numeric"
        ];

        $messages=[
            "apiToken.required"     =>400,
            "apiToken.exists"       =>405,

            "required_if"           =>400,
            
            "storeId.exists"        =>405,

            "categoryId.exists"     =>405,

            "page.required"         =>400,
            "page.numeric"          =>405
        ];

        $messagesAr=[   
            "apiToken.required"     =>"يجب ادخال التوكن",
            "apiToken.exists"       =>"هذا التوكن غير موجود",

            "required_if"           =>"يجب إرسال رقم القسم أو رقم المتجر",
            
            "storeId.exists"        =>"رقم المتجر غير موجود",

            "categoryId.exists"     =>"رقم القسم غير موجود",

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
