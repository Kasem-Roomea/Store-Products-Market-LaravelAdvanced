<?php

namespace App\Http\Controllers\Apis\Controllers\Ads;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\ads;

class AdsController extends index
{
    public static function api()
    {
        $screen=["offer"=>"offer","category"=>"categories","store"=>"stores","welcome"=>"welcome"];
        $records=  ads::allActiveOnly()
                      ->where("screen",$screen[self::$request->type])
                      ->when(self::$request->type=='category' && self::$request->categoryId,function($q){
                        return $q->where("categories_id",self::$request->categoryId);    
                      })
                      ->when(self::$request->type=='store' && self::$request->storeId,function($q){
                        return $q->where("stores_id",self::$request->storeId);    
                      })
                    //   ->where("stores_id",self::$request->storeId)    
                    //   ->where('endAt','>',date("Y-m-d"))
                    //   ->where('startAt','<=',date("Y-m-d"))
                    ;

        return [
            "status"=>$records->forPage(self::$request->page+1,self::$itemPerPage)->count()?200:204,
            "totalPages"=>ceil($records->count()/self::$itemPerPage),
            "Ads"=>objects::ArrayOfObjects($records->forPage(self::$request->page+1,self::$itemPerPage),"ad"),
        ];
    }
}