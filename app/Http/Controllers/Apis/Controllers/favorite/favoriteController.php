<?php
namespace App\Http\Controllers\Apis\Controllers\favorite;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\favorites;

class favoriteController extends index
{
    public static function api(){

        $record=  favorites::where('products_id',self::$request->productId)->where('users_id',self::$account->id)->first();
        if($record){
            $record->delete();
            $message="unFave";
        }else{
            favorites::createUpdate([
                "products_id"=>self::$request->productId,
                "users_id"=>self::$account->id,
            ]);
            $message="fave";
        }
        return [
            "status"=>200,
            "message"=>$message
        ];
    }
}

