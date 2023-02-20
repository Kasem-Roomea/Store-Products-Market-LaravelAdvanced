<?php
namespace App\Http\Controllers\Apis\Controllers\getUsers;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper ;

class getUsersRules extends index
{
    public static function rules (){
        
        $rules=[
            "apiToken"      =>"required|exists:users,api_token",
            "name"          =>"nullable|min:1",
            "generalRoomId" =>"exists:general_rooms,id",
            "privateRoomId" =>"exists:private_rooms,id",
            "page"          =>"required|numeric"
    
        ];
    
        $messages=[
            "apiToken.required"     =>400,
            "apiToken.exists"       =>405,
    
            "name.min"              =>405,
    
            "generalRoomId.exists"  =>405,
           
            "privateRoomId.exists"  =>405,
    
            "page.required"         =>400,
            "page.numeric"          =>405
    
        ];
    
        $messagesAr=[   
            "apiToken.required"     =>"يجب ادخال التوكن",
            "apiToken.exists"       =>"هذا التوكن غير موجود",
    
            "name.min"              =>"يجب ان لا يقل الاسم عن حرف",
        
            "generalRoomId.exists"  =>"هذه الغرفة غير موجودة",
    
            "privateRoomId.exists"  =>"هذه الغرفة غير موجودة",
    
            "page.required"         =>"يجب ادخال رقم الصفحة",
            "page.numeric"          =>"يجب ادخال رقم الصفحة بشكل صحيح",
    
        ];
    
        $messagesEn=[
        ];
        $ValidationFunction=self::$request->showAllErrors==1?"showAllErrors":"Validator";
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }
        if(self::$request->has('privateRoomId') && self::$request->has('generalRoomId') )
            return ['status'=>405,'message'=>" يجب إدخال رقم الغرفة العامة فقط أو رقم الغرفة الخاصة فقط وليس الاثنان معاََ"];
        return helper::validateAccount()??null;
    }
}
