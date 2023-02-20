<?php

namespace App\Http\Controllers\Apis\Controllers\getProfile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper ;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;

class getProfileController extends index
{
    public static function api(){

        $record=  self::$secondAccount;
        if(  !$record ||  !$record->is_active || !$record->is_verified || $record->deleted_at   )
            return [ 
                'status'=>204,
                'message'=>'لا يمكن الوصول لهذا الشخص حاليا '
            ];
        return [
            "status"=>200,
            "user"=>objects::profile($record),
        ];
    }
}