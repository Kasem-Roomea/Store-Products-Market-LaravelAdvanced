<?php

namespace App\Http\Controllers\Apis\Controllers\logout;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper ;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\users;

class logoutController extends index
{
    public static function api(){

        self::$account->fireBaseToken=NULL;
        self::$account->save();
        $name= self::$account->name;
        $message ="  نتمني رجوعك في أقرب وقت {$name} تم تسجيل الخروج بنجاح يا  ";
        return [
            "status"=>200,
            "message"=>$message
        ];
    }
}

