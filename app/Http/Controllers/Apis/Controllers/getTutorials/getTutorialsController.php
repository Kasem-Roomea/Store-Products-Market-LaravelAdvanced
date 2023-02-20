<?php

namespace App\Http\Controllers\Apis\Controllers\getTutorials;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\tutorials;

class getTutorialsController extends index
{
    public static function api(){

        $records=  tutorials::all()
                            ->makeHidden(["nameAr","nameEn","titleAr","titleEn","descriptionAr","descriptionEn","isActive","createdAt","categories_id","deletedAt"]);
        return [
            "status"=>$records->forPage(self::$request->page+1,self::$itemPerPage)->count()?200:204,
            "totalPages"=>ceil($records->count()/self::$itemPerPage),
            "tutorials"=>helper::only($records->forPage(self::$request->page+1,self::$itemPerPage),self::$request->parameters),
        ];
    }
}