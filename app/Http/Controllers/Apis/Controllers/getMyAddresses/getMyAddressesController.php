<?php
namespace App\Http\Controllers\Apis\Controllers\getMyAddresses;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\myAddress;

class getMyAddressesController extends index
{
    public static function api(){

        $records=  myAddress::where("users_id",self::$account->id)->where("deletedAt",null)->get();
        return [
            "status"=>$records->forPage(self::$request->page+1,self::$itemPerPage)->count()?200:204,
            "totalPages"=>ceil($records->count()/self::$itemPerPage),
            "myAddress"=>$records->forPage(self::$request->page+1,self::$itemPerPage),
        ];
    }
}