<?php

namespace App\Http\Controllers\Apis\Controllers\setFireBaseToken;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper ;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\users;
use App\Models\providers;

class setFireBaseTokenController extends index
{ 
    public static function api(){

        $type='App\Models\\'.self::$account->getTable();
        $type::createUpdate([
            'id'=>self::$account->id,
            'firebaseToken'=>self::$request->fireToken
        ]);
    $message="تم تغيير رقم الجهاز بنجاح";
        return [
            "status"=>200,
            "message"=>$message
        ];
                    

    }
}

