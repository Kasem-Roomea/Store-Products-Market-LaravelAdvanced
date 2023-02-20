<?php

namespace App\Http\Controllers\Apis\Controllers\changePassword;
use  App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\sessions;
use App\Http\Controllers\Apis\Helper\helper ;

class changePasswordController extends index
{
    public static function api(){

    sessions::whereIn('id',index::$account->sessions->pluck('id')->toArray())->delete(); 
    helper::changePassword();
    self::$account->isVerified=1;
    self::$account->save();
    return ['status'=>200];
    }    
}
