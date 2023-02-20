<?php
namespace App\Http\Controllers\Apis\Controllers\competeRegisterAsDriver;
 
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class competeRegisterAsDriverRules extends index
{
    public static function rules (){
        

        $rules=[
            "apiToken"                  =>"required",
            "vehicleId"                 =>"required|exists:vehicles,id",
            "frontIdImage"              =>"required",
            "rearIdImage"               =>"required",
            "frontDrivingLicenseImage"  =>"required",
            "rearDrivingLicenseImage"   =>"required",
            "frontVehicleLicenseImage"  =>"required",
            "rearVehicleLicenseImage"   =>"required",
            "frontVehicleImage"         =>"required",
            "rearVehicleImage"          =>"required",
        ];

        $messages=[
            "apiToken.required"                =>400,
            "apiToken.exists"                  =>405,

            "vehicleId.required"               =>400,
            "vehicleId.exists"                 =>405,
            
            "frontIdImage.required"            =>400,
            
            "rearIdImage.required"             =>400,
            
            "frontDrivingLicenseImage.required"=>400,
            
            "rearDrivingLicenseImage.required" =>400,
            
            "frontVehicleLicenseImage.required"=>400,
            
            "rearVehicleLicenseImage.required" =>400,
            
            "frontVehicleImage.required"       =>400,
            
            "rearVehicleImage.required"         =>400,
        ];

        $messagesAr=[   
            "apiToken.required"                =>"يجب ادخال التوكن",
            "apiToken.exists"                  =>"هذا التوكن غير موجود",

            "userId.exists"                    =>"هذه الشاحنة غير موجودة",
            "userId.required"                  =>"يجب ادخال رقم الشاحنة",

            "frontIdImage.required"            =>"يجب إدخال صررة البطاقة الشخصية الأمامية الخاصة بالسائق",
            
            "rearIdImage.required"             =>"يجب إدخال صررة البطاقة الشخصية الخلفية الخاصة بالسائق",

            "frontDrivingLicenseImage.required"=>"يجب إدخال صررة البطاقة الشخصية الخلفية الخاصة بالسائق",

            "rearIdImage.required"              =>"يجب إدخال صررة البطاقة الشخصية الخلفية الخاصة بالسائق",
 
            "frontDrivingLicenseImage.required" =>"يجب إدخال صورة الرخصة الشخصية الامامية  الخاصة بالسائق",
          
            "rearDrivingLicenseImage.required"  =>"يجب إدخال صورة الرخصة الشخصية الخلفية الخاصة بالسائق",

            "frontVehicleLicenseImage.required" =>"يجب إدخال صورة رخصة الشاحنة الامامية  ",

            "rearVehicleLicenseImage.required"  =>"يجب إدخال صورة رخصة الشاحنة الامامية  ",

            "frontVehicleImage.required"        =>"يجب إدخال صورة الشاحنة الامامية  ",

            "rearVehicleImage.required"          =>"يجب إدخال صورة الشاحنة الامامية  ",
        ];

        $messagesEn=[
        ];
        $ValidationFunction=self::$request->showAllErrors==1?"showAllErrors":"Validator";
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }

        return helper::validateAccount()??null;
    }
}
