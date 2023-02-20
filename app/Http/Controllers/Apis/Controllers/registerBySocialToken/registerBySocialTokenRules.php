<?php
namespace App\Http\Controllers\Apis\Controllers\registerBySocialToken;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Models\regions;

class registerBySocialTokenRules extends index
{
    public static function rules (){




        $rules=[
            "name"              =>"required|min:3",
            "type"              =>"required|in:user,driver",
            "phone"             =>"required|numeric|between:10000000000,99999999999999999999|unique:users,phone|unique:drivers,phone|unique:stores,phone",
            "email"             =>"unique:users,email|unique:drivers,email|unique:stores,email",
            "socialToken" =>"required|unique:users,social_token",
            "language"          =>"required|in:Ar,En",
            "deliveryMethodId"  =>"required_if:type,driver|exists:delivery_methods,id",
            "model"             =>"required_if:type,driver",
            "licenseNumber"     =>"required_if:type,driver",
            "carLicenseImage"   =>"required_if:type,driver",
            "driverLicenseImage"=>"required_if:type,driver",
            "IdPhoto"           =>"required_if:type,driver",
            "carImage"          =>"required_if:type,driver",
            
        ];

        $messages=[
            "name.required"      =>400,
            "name.min"           =>405,

            "type.required"             =>400,
            "type.in"                   =>405,

            "phone.required"            =>400,
            "phone.numeric"             =>405,
            "phone.between"             =>405,
            "phone.unique"              =>408,

            "email.unique"              =>408,

            "image.required"            =>400,

            "password.required"         =>400,
            "password.min"              =>405,

            "language.required"         =>400,
            "language.in"               =>405,

            "socialToken.required"  =>405,
            "socialToken.unique"       =>405,

            "deliveryMethodId.required_if"  =>405,
            "deliveryMethodId.exists"       =>405,

            "model.required_if"             =>405,

            "licenseNumber.required_if"     =>405,

            "carLicenseImage.required_if"   =>405,

            "driverLicenseImage.required_if"=>405,

            "IdPhoto.required_if"           =>405,

            "carImage.required_if"          =>405,
        ];

        $messagesAr=[

            "name.required"     =>"يجب ادخال الاسم",
            "name.min"          =>"يجب ان لا يقل الاسم عن 3 حروف ",

            "type.required"     =>"يجب ادخال نوع المستخدم",
            "type.in"           =>" user Or driver يجب ان يكون النوع  ",

            "phone.required"    =>"يجب ادخال رقم التليفون   ",
            "phone.nemeric"     =>"يجب ادخال رقم التليفون بشكل صحيح ",
            "phone.between"     =>"يجب ان لا يقل رقم التليفون عن 11 ارقام ولا يزيد عن 15 رقم ",
            "phone.unique"      =>"هذا الهاتف مسجل مسبقا",
            
            "email.unique"      =>"هذا البريد الإلكتروني مسجل مسبقا",

            "image.required"    =>"يجب ادخال صورة المستخدم ",

            "password.required" =>"يجب ادخال الرقم السري",
            "password.min"      =>"يجب ان لا يقل الرقم السري عن 6 ارقام او حروف",

            "language.required"     =>"يجب ادخال اللغة ",
            "language.in"           =>" Ar , En يجب ادخال اللغة بشكل صحيح ",

            "socialToken.required" =>"يجب ادخال السوشيال توكن ",
            "socialToken.unique"      =>"هذا السوشيال توكن مسجل مسبقا",

            "deliveryMethodId.required_if"  =>"يجب إختيار طريقة التوصيل",
            "deliveryMethodId.exists"       =>"يجب إختيار طريقة التوصيل بشكل صحيح",

            "model.required_if"             =>"يجب إدخال رقم الموديل",

            "licenseNumber.required_if"     =>"يجب إدخال رقم الرخصة ",

            "carLicenseImage.required_if"   =>"يجب إدخال صورة رخصة السيارة",

            "driverLicenseImage.required_if"=>"يجب إدخال صورة رخصة السائق",

            "IdPhoto.required_if"           =>"يجب إدخال صورة البطاقة الشخصية",

            "carImage.required_if"          =>"يجب إدخال صورة السيارة "
        ];

        $messagesEn=[
            
        ];
        $ValidationFunction=self::$request->showAllErrors==1?'showAllErrors':'Validator';
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="Ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }    

    }
}
