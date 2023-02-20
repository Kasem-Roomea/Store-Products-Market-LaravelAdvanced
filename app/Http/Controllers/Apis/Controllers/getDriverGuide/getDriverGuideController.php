<?php

namespace App\Http\Controllers\Apis\Controllers\getDriverGuide;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\guide_to_driver;

class getDriverGuideController extends index
{
    public static function api(){

        $records=  guide_to_driver::all();
        return [
            "status"=>$records->forPage(self::$request->page+1,self::$itemPerPage)->count()?200:204,
            "totalPages"=>ceil($records->count()/self::$itemPerPage),
            "driverGuides"=>helper::only($records->forPage(self::$request->page+1,self::$itemPerPage),self::$request->parameters),
        ];
    }
}