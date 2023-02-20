<?php

namespace App\Http\Controllers\Apis\Controllers\updateFcmToken;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\ModelName;

class updateFcmTokenController extends index
{
    public static function api(){

        $records=  ModelName::allActive();
        $message="";
        return [
            "status"=>$records->forPage(self::$request->page+1,self::$itemPerPage)->count()?200:204,
            "totalPages"=>ceil($records->count()/self::$itemPerPage),
            "arrayobjectsNAme"=>objects::ArrayOfObjects($records->forPage(self::$request->page+1,self::$itemPerPage),"objectsNAme"),
            "objectsNAme"=>helper::only($records->forPage(self::$request->page+1,self::$itemPerPage),self::$request->parameters),
            "message"=>$message
        ];
                    

    }
}

