<?php
namespace App\Http\Controllers\Apis\Controllers\getBrands;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class getBrandsRules extends index
{
    public static function rules (){
        
        $rules=[
            "brandId"     =>"exists:brands,id",
            "subCategoryId" =>"nullable",
            "page"      =>"required|numeric"
        ];

        $messages=[
            "brandId.required"       =>400,
            "brandId.exists"         =>405,

            "page.required"         =>400,
            "page.numeric"          =>405
        ];

        $messagesAr=[   
            "brandId.exists"         =>"هذا الرقم غير موجود",
            "brandId.required"       =>"يجب ادخال رقم القسم",

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
