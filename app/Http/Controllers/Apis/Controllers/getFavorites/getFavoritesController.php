<?php
namespace App\Http\Controllers\Apis\Controllers\getFavorites;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\favorites;
use App\Models\products;

class getFavoritesController extends index
{
    public static function api(){

        $records=  products::find(favorites::where('users_id',self::$account->id)->pluck("products_id"));
        return [
            "status"=>$records->count()?200:204,
            "totalPages"=>ceil($records->count()/self::$itemPerPage),
            "products"=>objects::ArrayOfObjects($records->forPage(self::$request->page+1,self::$itemPerPage),"product"),
        ];
    }
}

