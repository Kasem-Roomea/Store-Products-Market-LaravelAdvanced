<?php
namespace App\Http\Controllers\Apis\Controllers\getDistricts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\regions;

class getDistrictsController extends index
{
    public static function api()
    {
        $records= regions::allActiveOnly()
                         ->where('type','district')
                         ->where('regions_id',self::$request->cityId)
                         ->makeHidden(["nameAr","nameEn","isActive","createdAt","regions_id","deletedAt"]);
        return [
            "status"=>$records->forPage(self::$request->page+1,self::$itemPerPage)->count()?200:204,
            "totalPages"=>ceil($records->count()/self::$itemPerPage),
            "districts"=>helper::only($records->forPage(self::$request->page+1,self::$itemPerPage),self::$request->parameters),
        ];
    }
}

