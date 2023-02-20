<?php
namespace App\Http\Controllers\Apis\Controllers\getStores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\stores;
use App\Models\app_settings;

class getStoresController extends index
{
    public static function api()
    {
        $records= stores::where("isActive",1)->where('isVerified',1)->where("categories_id",self::$request->categoryId)->get();
        if(self::$request->has("location")){
            $records=  $records->where('distance','<=',app_settings::first()->radius);
        }
        
        if(self::$request->has('search') ) {
            $search=self::$request->search;
            $records = $records->filter(function($item) use ($search) {
                if(stripos($item['name'],$search) !== false )
                    return true;
                });
        }
        if(self::$request->sortByDistance){
            $records =  $records->sortByDesc('distance');
        }
        if(self::$request->has("storeId")){
            return [
                "status"=>200,
                "store"=>objects::store(stores::find(self::$request->storeId)),
            ];
        }else{
            $stores= objects::ArrayOfObjects($records->forPage(self::$request->page+1,self::$itemPerPage),"store");
            return [
                "status"=>$records->forPage(self::$request->page+1,self::$itemPerPage)->count()?200:204,
                "totalPages"=>ceil($records->count()/self::$itemPerPage),
                "stores"=>$stores,
            ];
        }
    }
}