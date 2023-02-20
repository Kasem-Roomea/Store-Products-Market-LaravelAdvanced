<?php

namespace App\Http\Controllers\Apis\Controllers\myFavourites;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\stores;
use App\Models\favourites;

class myFavouritesController extends index
{
    public static function api()
    {
        $records=  stores::allActiveOnly()->whereIn('id',favourites::where('users_id',self::$account->id)->pluck('stores_id'));
        return [
            "status"=>$records->forPage(self::$request->page+1,self::$itemPerPage)->count()?200:204,
            "totalPages"=>ceil($records->count()/self::$itemPerPage),
            "stores"=>objects::ArrayOfObjects($records->forPage(self::$request->page+1,self::$itemPerPage),"store"),
        ];
    }
}

