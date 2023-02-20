<?php
namespace App\Http\Controllers\Apis\Controllers\getContactUs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\contacts;

class getContactUsController extends index
{
    public static function api()
    {
        $records=  contacts::where("users_id",self::$account->id)
                           ->where("orders_id",null)
                           ->orderBy("id","DESC")
                           ->get();
        return [
            "status"=>$records->forPage(self::$request->page+1,self::$itemPerPage)->count()?200:204,
            "totalPages"=>ceil($records->count()/self::$itemPerPage),
            "contacts"=>helper::only($records->forPage(self::$request->page+1,self::$itemPerPage),self::$request->parameters),
        ];
    }
}