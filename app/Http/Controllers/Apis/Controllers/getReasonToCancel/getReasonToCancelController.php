<?php

namespace App\Http\Controllers\Apis\Controllers\getReasonToCancel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\ModelName;

class getReasonToCancelController extends index
{
    public static function api(){

        // $records=  ModelName::allActive();
        return [
            "status"=>200,
            // "status"=>$records->forPage(self::$request->page+1,self::$itemPerPage)->count()?200:204,
            // "totalPages"=>ceil($records->count()/self::$itemPerPage),
            // "objectsNAme"=>helper::only($records->forPage(self::$request->page+1,self::$itemPerPage),self::$request->parameters),
        ];
    }
}