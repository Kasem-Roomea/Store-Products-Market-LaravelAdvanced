<?php
namespace App\Http\Controllers\Apis\Controllers\socialLinks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\social_links;

class socialLinksController extends index
{
    public static function api()
    {
        if(self::$request->has("userId")){
            $key= "users_id";
            $val= self::$request->userId;
        }elseif(self::$request->has("shopId")){
            $key= "shops_id";
            $val= self::$request->shopId;
        }elseif(self::$request->has("providerId")){
            $key= "providers_id";
            $val= self::$request->providerId;
        }elseif(self::$request->has("appInfoId")){
            $key= "appInfo_id";
            $val= self::$request->appInfoId;
        }  
        $records=  social_links::where( $key, $val)->get()
                               ->makeHidden(["appInfo_id","shops_id","users_id","providers_id","deletedAt"]);
        return [
            "status"=>$records->forPage(self::$request->page+1,self::$itemPerPage)->count()?200:204,
            "totalPages"=>ceil($records->count()/self::$itemPerPage),
            "social"=>helper::only($records->forPage(self::$request->page+1,self::$itemPerPage),self::$request->parameters),
        ];
    }
}