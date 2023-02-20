<?php
namespace App\Http\Controllers\Apis\Controllers\addRating;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class addRatingRules extends index
{
    public static function rules ()
    {
        $rules=[
            "apiToken"            =>"required",
            "reviews"             =>"required|array",
            "reviews.*.type"      =>"required|in:user,driver,store,user,product,order",
            "reviews.*.targetId"  =>"required",
            // "reviews.*.productId" =>"exists:products,id",
            // "reviews.*.storeId"   =>"exists:stores,id",
            // "reviews.*.driverId"  =>"exists:drivers,id",
            // "reviews.*.userId"    =>"exists:users,id",
            "reviews.*.rate"    =>"required|numeric|min:1|max:5",
        ];

        $messages=[
            "apiToken.required"          =>400,
            "apiToken.exists"            =>405,

            "reviews.*.targetId.required"  =>400,

            "reviews.*.type.required"  =>400,

            // "reviews.*.storeId.exists"    =>405,

            // "reviews.*.driverId"          =>405,
     
            // "reviews.*.userId"            =>405,
            
            "reviews.*.rate.required"              =>400,
            "reviews.*.rate.min"                   =>405,
            "reviews.*.rate.max"                   =>405
        ];

        $messagesAr=[   
            "apiToken.required"          =>"يجب ادخال التوكن",
            "apiToken.exists"            =>"هذا التوكن غير موجود",

            "reviews.array"               =>"يجب إدخال الريفيو اوبجيكت  ",

            "reviews.array"               =>"يجب إدخال الريفيو اوبجيكت بشكل صحيح",

            "reviews.*.type.in"           =>"يجب إدخال النوع",
            "reviews.*.type.required"     =>"هذا المنتج غير موجود",

            "reviews.*.targetId.required"  =>"يجب إدخال التارجت اي دي",

            // "reviews.*.productId.exists"   =>"هذا المنتج غير موجود",

            // "reviews.*.storeId.exists"     =>"هذا المتجر غير موجود",

            // "reviews.*.driverId.exists"    =>"هذا السائق غير موجود",

            // "reviews.*.userId.exists"      =>"هذا المتجر غير موجود",

            "required_without_all"        =>"يجب إدخال رقم السائق او رقم المتجر او رقم المنتج او رقم الشخص",
            
            "reviews.*.rate.required"               =>"يجب إدخال التقييم",
            "reviews.*.rate.min"                    =>"يجب إدخال التقييم من 1 الي 5",
            "reviews.*.rate.max"                    =>"يجب إدخال التقييم من 1 الي 5",
        ];

        $messagesEn=[
        ];
        $ValidationFunction=self::$request->showAllErrors==1?"showAllErrors":"Validator";
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }

        return helper::validateAccount()??null;
    }
}
