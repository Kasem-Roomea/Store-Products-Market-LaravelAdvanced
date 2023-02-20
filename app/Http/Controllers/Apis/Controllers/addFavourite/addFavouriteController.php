<?php

namespace App\Http\Controllers\Apis\Controllers\addFavourite;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\stores;
use App\Models\favourites;

class addFavouriteController extends index
{
    public static function api()
    {
        
        $favourites= favourites::where('users_id',self::$account->id)->where('stores_id',self::$request->storeId)->first();
        if($favourites){
            $message=self::$messages['favourite']['unfav'];
            $favourites->delete();
        }else{
            favourites::createUpdate([
                'users_id'=>self::$account->id,
                'stores_id'=>self::$request->storeId
            ]);
            $message=self::$messages['favourite']['fav'];
        }
        return [
            "status"=>200,
            "message"=>$message,
        ];
    }
}