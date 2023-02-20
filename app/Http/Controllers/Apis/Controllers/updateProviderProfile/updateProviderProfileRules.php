<?php
namespace App\Http\Controllers\Apis\Controllers\updateProviderProfile;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class updateProviderProfileRules extends index
{
    public static function rules (){
            
        $rules=[
            "apiToken"   =>"required",
            "name"     =>"min:3",
            "phone"    =>"numeric|numeric|between:100000000,99999999999999999999|unique:users,phone|unique:drivers,phone|unique:stores,phone",
            "email"    =>"unique:users,email|unique:drivers,email|unique:stores,email",
            "image"    =>"nullable"
        ];

        $messages=[
            "apiToken.required"  =>400,
            "apiToken.exists"    =>405,

            "name.min"           =>405,


            "phone.numeric"      =>405,
            "phone.between"      =>405,
            "phone.unique"       =>408,

            // "regionId.exists"    =>405,

        ];

        $messagesAr=[
            "apiToken.required" =>"يجب ادخال التوكن",
            "apiToken.exists"   =>"هذا التوكن غير موجود",

            "name.min"          =>"يجب ان لا يقل الاسم عن 3 حروف ",

            "phone.numeric"     =>"يجب ادخال رقم التليفون بشكل صحيح",
            "phone.between"     =>"يجب ان لا يقل رقم التليفون عن 11 ارقام ولا يزيد عن 15 رقم ",
            "phone.unique"      =>"هذا الهاتف مسجل مسبقا",
         ];

        $messagesEn=[
            
        ];
        $ValidationFunction=self::$request->showAllErrors==1?'showAllErrors':'Validator';
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }    

        return helper::validateAccount()??null; 
    }
}
