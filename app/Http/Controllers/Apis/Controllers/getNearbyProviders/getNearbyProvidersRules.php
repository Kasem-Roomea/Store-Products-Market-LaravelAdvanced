<?php
namespace App\Http\Controllers\Apis\Controllers\getNearbyProviders;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class getNearbyProvidersRules extends index
{
    public static function rules (){
        
        $rules=[
            'location.longitude'  =>"required",
            'location.latitude'   =>"required",
        ];

        $messages=[
            "location.*.required"   =>400,
        ];

        $messagesAr=[   
            "location.*.required"   =>" longitude & latitude يجب إدخال ",
        ];

        $messagesEn=[
        ];
        $ValidationFunction=self::$request->showAllErrors==1?"showAllErrors":"Validator";
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }

        return helper::validateAccount()??null;
    }
}
