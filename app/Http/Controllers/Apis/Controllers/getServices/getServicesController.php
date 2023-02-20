<?php

namespace App\Http\Controllers\Apis\Controllers\getServices;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\services;
use App\Models\stores;
use App\Models\services_in_store;

class getServicesController extends index
{
    public static function api()
    {

        if(self::$request->has('storeId')){
            $search=self::$request->search;
            $records=  services_in_store::where("stores_id",self::$request->storeId)->get();
            $records  = $records->filter(function($item) use ($search) {
                            return   $item->services->is_active;
                        });
            
        }elseif(self::$request->has('categoryId')){ 
            $records=services::allActiveOnly()->where('categories_id',self::$request->categoryId);
            if(self::$request->has('search') ) {
                $search=self::$request->search;
                $records = $records->filter(function($item) use ($search) {
                    if(stripos($item['name_ar'],$search) !== false || stripos($item['name_en'],$search) !== false)
                        return true;
                    else
                        return false; 
                });
            }
        }
        return [
            "status"=>$records->forPage(self::$request->page+1,self::$itemPerPage)->count()?200:204,
            "totalPages"=>ceil($records->count()/self::$itemPerPage),
            "services"=>objects::ArrayOfObjects($records->forPage(self::$request->page+1,self::$itemPerPage),"service"),
        ];
    }
}