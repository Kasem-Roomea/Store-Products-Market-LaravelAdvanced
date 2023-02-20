<?php

namespace App\Http\Controllers\Apis\Controllers\resetPassword;
use  App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\sessions;
use App\Http\Controllers\Apis\Helper\helper ;

class resetPasswordController extends index
{
    public static function api(){

    sessions::whereIn('id',self::$account->sessions->pluck('id')->toArray())->delete(); 
    helper::changePassword();
    return ['status'=>200];
    }    
}
