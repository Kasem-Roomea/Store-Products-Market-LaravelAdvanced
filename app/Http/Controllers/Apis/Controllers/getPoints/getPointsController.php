<?php
namespace App\Http\Controllers\Apis\Controllers\getPoints;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\points;

class getPointsController extends index
{
    public static function api()
    {
        $records=  points::allActive();
        return [
            "status"=>$records->forPage(self::$request->page+1,self::$itemPerPage)->count()?200:204,
            "totalPages"=>ceil($records->count()/self::$itemPerPage),
            "points"=>objects::ArrayOfObjects($records->forPage(self::$request->page+1,self::$itemPerPage),"Points"),
        ];
    }
}