<?php
namespace App\Http\Controllers\Apis\Controllers\getCities;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\regions;

class getCitiesController extends index
{
    public static function api()
    {
        $records= regions::allActiveOnly()
                         ->where('type','city')
                         ->where('regions_id',self::$request->countryId)
                         ->makeHidden(["nameAr","nameEn","isActive","createdAt","regions_id","deletedAt"]);
        return [
            "status"=>$records->forPage(self::$request->page+1,self::$itemPerPage)->count()?200:204,
            "totalPages"=>ceil($records->count()/self::$itemPerPage),
            "cities"=>helper::only($records->forPage(self::$request->page+1,self::$itemPerPage),self::$request->parameters),
        ];
    }
}