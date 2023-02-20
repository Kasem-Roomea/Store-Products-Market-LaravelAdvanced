<?php

namespace App\Http\Controllers\Apis\Controllers\getReportsTypes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper ;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\reports_types;

class getReportsTypesController extends index
{
    public static function api(){

        $records=  reports_types::allActive();
        return [
            "status"=>$records->forPage(self::$request->page+1,self::$itemPerPage)->count()?200:204,
            "totalPages"=>ceil($records->count()/self::$itemPerPage),
            "reportsTypes"=>objects::ArrayOfObjects($records->forPage(self::$request->page+1,self::$itemPerPage),"reportType"),
        ];
    }
}