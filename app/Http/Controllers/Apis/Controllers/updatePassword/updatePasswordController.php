<?php

namespace App\Http\Controllers\Apis\Controllers\updatePassword;
use  App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\sessions;
use App\Http\Controllers\Apis\Helper\helper ;

class updatePasswordController extends index
{
    public static function api(){

    if(!helper::updatePassword()){
        return [
            'status'=>414 ,
            'message'=>self::$messages['updatePassword']["414"]
        ];
    }else
        return ['status'=>200];
    }    
}