<?php
namespace App\Http\Controllers\Apis\Controllers\getMyStores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\stores;

class getMyStoresController extends index
{
    public static function api()
    {
        $records=  stores::allActiveOnly()->where('providers_id',self::$account->id);
        return [
            "status"=>$records->forPage(self::$request->page+1,self::$itemPerPage)->count()?200:204,
            "totalPages"=>ceil($records->count()/self::$itemPerPage),
            "stores"=>objects::ArrayOfObjects($records->forPage(self::$request->page+1,self::$itemPerPage),"store"),
        ];
    }
}