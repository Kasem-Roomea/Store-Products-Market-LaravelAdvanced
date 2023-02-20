<?php
namespace App\Http\Controllers\Apis\Controllers\addAddresses;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class addAddressesRules extends index
{
    public static function rules ()
    {
        $rules=[
            "apiToken"            =>"required",
            'location.longitude'  =>"required",
            'location.latitude'   =>"required",
            'location.address'    =>"required",
            "isDefaultAddress"    =>"required|bool",
            "description"         =>"nullable",
            "locationId"          =>"nullable|exists:myAddress,id",
        ];
        $messages=[
            "apiToken.required"     =>400,
            "apiToken.exists"       =>405,

            "locationId.exists"       =>405,

            "location.*.required"   =>400,

            "isDefaultAddress.required" =>400,   
            "isDefaultAddress.bool" =>400,   
        ];
        $messagesAr=[   
            "apiToken.required"     =>"يجب ادخال التوكن",
            "apiToken.exists"       =>"هذا التوكن غير موجود",

            "location.*.required"   =>" longitude & latitude & address يجب إدخال ",
        
            "isDefaultAddress.required" =>"يجب إدخال  isDefaultAddress",   
            "isDefaultAddress.bool" =>"isDefaultAddress يجب أن يكون القيمة true Or false",   

            "locationId.required"     =>"رقم النوان غير موجود",

        ];

        $messagesEn=[
        ];
        $ValidationFunction=self::$request->showAllErrors==1?"showAllErrors":"Validator";
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }

        return helper::validateAccount()??null;
    }
}
