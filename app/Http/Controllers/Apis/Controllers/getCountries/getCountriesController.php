<?php
namespace App\Http\Controllers\Apis\Controllers\getCountries;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\regions;

class getCountriesController extends index
{
    public static function api()
    {
        $records= regions::allActiveOnly()->where('type','country')
                         ->makeHidden(["nameAr","nameEn","isActive","createdAt","regions_id","deletedAt"]);
        return [
            "status"=>$records->forPage(self::$request->page+1,self::$itemPerPage)->count()?200:204,
            "totalPages"=>ceil($records->count()/self::$itemPerPage),
            "countries"=>helper::only($records->forPage(self::$request->page+1,self::$itemPerPage),self::$request->parameters),
        ];
    }
}