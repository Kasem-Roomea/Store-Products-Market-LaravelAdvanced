<?php

namespace App\Http\Controllers\Apis\Controllers\getReviews;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\reviews;

class getReviewsController extends index
{
    public static function api()
    {
        $records=  reviews::all()->where(self::$request->type."s_id",self::$request->targetId)
                          ->makeHidden([
                                "nameAr","nameEn","titleAr","titleEn","descriptionAr","descriptionEn",
                                "isActive","created","categories_id","deletedAt","reviews",
                                "shops_id","products_id","providers_id","drivers_id","users_id","orders_id"
                            ]);
        return [
            "status"=>$records->forPage(self::$request->page+1,self::$itemPerPage)->count()?200:204,
            "totalPages"=>ceil($records->count()/self::$itemPerPage),
            "reviews"=>helper::only($records->forPage(self::$request->page+1,self::$itemPerPage),self::$request->parameters),
            "totalNumberReviews"=>$records->count()
        ];
    }
}