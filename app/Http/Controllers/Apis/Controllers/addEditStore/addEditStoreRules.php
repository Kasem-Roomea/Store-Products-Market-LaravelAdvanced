<?php
namespace App\Http\Controllers\Apis\Controllers\addEditStore;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class addEditStoreRules extends index
{
    public static function rules (){
        
        $rules=[
            "apiToken"           =>"required|exists:providers,apiToken",
            "storeId"            =>"exists:stores,id",
            "logo"               =>"required",
            "images"             =>"nullable|array|min:4|max:6",
            "phones"             =>"nullable|array|min:1|max:3",
            "name"               =>"required|min:2|max:50",
            "description"        =>"required|min:5|max:200",
            "categoryId"         =>"required|exists:categories,id",
            "fromDay"            =>"required|exists:days,id",
            "toDay"              =>"required|exists:days,id",
            "fromTime"           =>"required|date_format:H:i:s",
            "toTime"             =>"required|date_format:H:i:s|after:fromTime",
            "facebook"           =>"required|url",
            "twitter"            =>"required|url",
            "instagram"          =>"required|url",
            "location"           =>"required",
            "location.longitude" =>"required",
            "location.latitude"  =>"required",
            "location.address"   =>"required"
        ];
        $messages=[
            "apiToken.required"     =>400,
            "apiToken.exists"       =>405,

            "logo.required"         =>400,

            "images.required"       =>400,
            "images.array"          =>405,
            "images.min"            =>405,
            "images.max"            =>405,

            "phones.required"       =>400,
            "phones.array"          =>405,
            "phones.min"            =>405,
            "phones.max"            =>405,

            "name.required"         =>400,
            "name.min"              =>405,
            "name.max"              =>405,
           
            "description.required"  =>400,
            "description.min"       =>405,
            "description.max"       =>405,

            "categoryId.required"   =>400,
            "categoryId.exists"     =>405,

            "fromDay.required"      =>400,
            "fromDay.exists"        =>405,

            "toDay.required"        =>400,
            "toDay.exists"          =>405,

            "fromTime.required"     =>400,
            "fromTime.date_format"  =>405,

            "toTime.required"       =>400,
            "toTime.date_format"    =>405,
            "toTime.after"          =>405,

            "facebook.required"     =>400,
            "facebook.url"          =>405,

            "twitter.required"      =>400,
            "twitter.url"           =>405,

            "instagram.required"    =>400,
            "instagram.url"         =>405,

            "location.required"     =>400,
            "location.*.required"   =>400,
        ];

        $messagesAr=[   
            "apiToken.required"     =>"يجب ادخال التوكن",
            "apiToken.exists"       =>"هذا التوكن غير موجود",

            "logo.required"         =>"يجب إدخال اللوجو",
             
            "images.required"       =>"يجب ادخال صور",
            "images.array"          =>"يجب ادخال ارراي بها مجموعة الصور",
            "images.min"            =>"يجب ادخال علي الاقل 4 صور للمتجر",
            "images.max"            =>"يجب ادخال علي الاكثر 6 صور للمتجر",

            "phones.required"       =>"يجب ادخال أرقام التليفون الخاص بالمتجر",
            "phones.array"          =>"يجب ادخال ارراي بها مجموعة أرقام",
            "phones.min"            =>"يجب ادخال علي الاقل 1 رقم تليفون للمتجر",
            "phones.max"            =>"يجب ادخال علي الاكثر 3 رقم تليفون للمتجر",


            "name.required"         =>"يجب إدخال الإسم",
            "name.min"              =>"يجب ان لا يقل الاسم عن حرفين",
            "name.max"              =>"يجب ان لا يزيد الاسم عن 50 حرف",
           
            "description.required"  =>"يجب إدخال الوصف",
            "description.min"       =>"يجب ان لا يقل الوصف عن 5 حروف ",
            "description.max"       =>"يجب ان لا يزيد الاسم عن 200 حرف",

            "categoryId.required"   =>"يجب إدخال القسم",
            "categoryId.exists"     =>"رقم القسم غير موجود",

            "fromDay.required"      =>"يجب ادخال يوم بداية العمل ",
            "fromDay.exists"        =>" يجب ادخال يوم بداية العمل بشكل صحيح",

            "toDay.required"        =>"يجب ادخال يوم نهاية العمل ",
            "toDay.exists"          =>" يجب ادخال يوم نهاية العمل بشكل صحيح",

            "fromTime.required"     =>"يجب ادخال ساعة بداية العمل",
            "fromTime.date_format"  =>"يجب ادخال ساعة بداية العمل بشكل صحيح",

            "toTime.required"       =>"يجب ادخال ساعة نهاية العمل",
            "toTime.date_format"    =>"يجب ادخال ساعة نهاية العمل بشكل صحيح",
            "toTime.after"          =>"يجب ان تكون ساعة البداية قبل ساعة النهاية ",

            "facebook.required"     =>"يجب ادخال رابط الفيس بوك",
            "facebook.url"          =>"يجب ادخال رابط الفيس بوك بشكل صحيح",

            "twitter.required"      =>"يجب ادخال رابط التويتر",
            "twitter.url"           =>"يجب ادخال رابط التويتر بشكل صحيح",

            "instagram.required"    =>"يجب ادخال رابط الانستجرام",
            "instagram.url"         =>"يجب ادخال رابط الانستجرام بشكل صحيح",

            "location.required"     =>"يجب ادخال الموقع",
            "location.*.required"   =>"  [longitude , latitude ,address] : يجب ادخال الموقع بشكل صحيح  ",
        ];
        $messagesEn=[
        ];
        $ValidationFunction=self::$request->showAllErrors==1?"showAllErrors":"Validator";
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }

        return helper::validateAccount()??null;
    }
}
