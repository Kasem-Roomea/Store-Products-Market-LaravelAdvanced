<?php

namespace App\Http\Controllers\Apis\Controllers\getRooms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\rooms;

class getRoomsController extends index
{
    public static function api(){

        $records= rooms::where(self::$account->getTable()."_id",self::$account->id)
                        ->get()
                        ->makeHidden([
                            "nameAr","nameEn","titleAr","titleEn","descriptionAr","descriptionEn",
                            "isActive","created","categories_id","deletedAt","reviews",
                            "shops_id","products_id","providers_id","drivers_id","users_id","orders_id"
                        ]);
;
        return [
            "status"=>$records->forPage(self::$request->page+1,self::$itemPerPage)->count()?200:204,
            "totalPages"=>ceil($records->count()/self::$itemPerPage),
            "rooms"=>helper::only($records->forPage(self::$request->page+1,self::$itemPerPage),self::$request->parameters),
        ];
    }
}