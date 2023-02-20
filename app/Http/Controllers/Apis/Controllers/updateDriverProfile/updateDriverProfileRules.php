<?php
namespace App\Http\Controllers\Apis\Controllers\updateDriverProfile;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class updateDriverProfileRules extends index
{
    public static function rules (){
            
        $rules=[
            "apiToken"         =>"required",
            "name"              =>"min:3",
            "phone"             =>"numeric|numeric|between:100000000,99999999999999999999|unique:users,phone|unique:drivers,phone|unique:stores,phone",
            "email"             =>"unique:users,email|unique:drivers,email|unique:stores,email",
            "image"             =>"nullable",
            "language"          =>"in:Ar,En",
            "deliveryMethodId"  =>"nullable|exists:delivery_methods,id",
            "model"             =>"nullable",
            "licenseNumber"     =>"nullable",
            "carLicenseImage"   =>"nullable",
            "driverLicenseImage"=>"nullable",
            "IdPhoto"           =>"nullable",
            "carImage"          =>"nullable",
            
        ];

        $messages=[
            "apiToken.required"  =>400,
            "apiToken.exists"    =>405,

            "name.min"                  =>405,

            "phone.numeric"             =>405,
            "phone.between"             =>405,
            "phone.unique"              =>408,

            "email.unique"              =>408,

            "password.min"              =>405,

            "language.in"               =>405,

            "deliveryMethodId.exists"       =>405,

        ];

        $messagesAr=[

            "apiToken.required" =>"يجب ادخال التوكن",
            "apiToken.exists"   =>"هذا التوكن غير موجود",

            "name.required"     =>"يجب ادخال الاسم",
            "name.min"          =>"يجب ان لا يقل الاسم عن 3 حروف ",

            "type.in"           =>" user Or driver يجب ان يكون النوع  ",

            "phone.nemeric"     =>"يجب ادخال رقم التليفون بشكل صحيح ",
            "phone.between"     =>"يجب ان لا يقل رقم التليفون عن 11 ارقام ولا يزيد عن 15 رقم ",
            "phone.unique"      =>"هذا الهاتف مسجل مسبقا",
            
            "email.unique"      =>"هذا البريد الإلكتروني مسجل مسبقا",

            "language.required"     =>"يجب ادخال اللغة ",
            "language.in"           =>" Ar , En يجب ادخال اللغة بشكل صحيح ",

            "deliveryMethodId.exists"       =>"يجب إختيار طريقة التوصيل بشكل صحيح",
        ];

        $messagesEn=[
            
        ];
        $ValidationFunction=self::$request->showAllErrors==1?'showAllErrors':'Validator';
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="Ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }    

        return helper::validateAccount()??null; 
    }
}
