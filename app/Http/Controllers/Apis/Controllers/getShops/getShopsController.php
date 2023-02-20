<?php
namespace App\Http\Controllers\Apis\Controllers\getShops;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Models\stores;

class getShopsController extends index
{
    public static function api()
    {
        $records=  stores::allActive()
                        ->makeHidden(["nameAr","nameEn","titleAr","titleEn","descriptionAr","descriptionEn","isActive","createdAt","categories_id","deletedAt","reviews"]);
        if(self::$request->has('mostRated')){
            $records=$records->sortByDesc("ratting");
        }
        if(self::$request->has('nearest')){
            $records=$records->sortByDesc("distance");
        }
        return [
            "status"=>$records->forPage(self::$request->page+1,self::$itemPerPage)->count()?200:204,
            "totalPages"=>ceil($records->count()/self::$itemPerPage),
            "shops"=>helper::only($records->forPage(self::$request->page+1,self::$itemPerPage),self::$request->parameters),
        ];
    }
}