<?php
namespace App\Http\Controllers\Apis\Controllers\getStores;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class getStoresRules extends index
{
    public static function rules (){
        
        $rules=[
            "sortByRate"         =>"in:true,false",
            "sortByDistance"     =>"bool",
            'storeId'            =>"exists:stores,id",
            'categoryId'         =>"exists:categories,id",
            // 'location'           =>"array|required_with:sortByDistance",
            // "location.longitude" =>"required_with:location",
            // "location.latitude"  =>"required_with:location",
            // "location.address"   =>"required_with:location",
            'search'             =>'string|min:1',
            "page"               =>"required_if:page,|numeric",
        ];

        $messages=[
            "apiToken.required"         =>400,
            "apiToken.exists"           =>405,

            "storeId.exists"            =>405,

            "categoryId.exists"         =>405,

            "location.required_with"    =>400,
            "location.array"            =>400,
            "location.*.required_with"  =>400,
            
            "search.min"                =>405,
            "search.string"             =>405,
            
            "sortByRate.in"             =>405,
            
            "sortByDistance.bool"         =>405,

            "page.required_if"          =>400,
            "page.numeric"              =>405
        ];

        $messagesAr=[   
            "apiToken.required"         =>"يجب ادخال التوكن",
            "apiToken.exists"           =>"هذا التوكن غير موجود",

            "storeId.exists"            =>"رقم المتجر غير موجود",

            "categoryId.exists"         =>"رقم القسم غير موجود",

            "location.array"            =>"[longitude , latitude ,address] : يجب ادخال الموقع بشكل صحيح  ",
            "location.required_with"    =>"يجب إدخال الموقع عند الترتيب بواسطة المسافة",
            "location.*.required_with"  =>"[longitude, latitude, address] : يجب ادخال الموقع بشكل صحيح  ",

            "search.min"                =>"يجب إدخال كلمة البحث بشكل صحيح",
            "search.string"             =>"يجب إدخال كلمة البحث بشكل صحيح",

            "sortByRate.in"             =>" true,false يجب إرسال الترتيب بواسطة التقييم بشكل صحيح ",
            
            "sortByDistance.bool"       =>" true,false يجب إرسال الترتيب بواسطة الاقرب بشكل صحيح ",
            
            "page.required_if"          =>"يجب ادخال رقم الصفحة",
            "page.numeric"              =>"يجب ادخال رقم الصفحة بشكل صحيح",
        ];

        $messagesEn=[
        ];
        $ValidationFunction=self::$request->showAllErrors==1?"showAllErrors":"Validator";
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }
        return helper::validateAccount()??null;
    }
}