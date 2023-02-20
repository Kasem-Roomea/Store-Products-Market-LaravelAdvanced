<?php

namespace App\Http\Controllers\Apis\Controllers\editAddress;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\myAddress;

class editAddressController extends index
{
    public static function api()
    {
        if(self::$request->has("isDefaultAddress")){
            $lastDefaultMyAddresss = myAddress::where(self::$account->getTable()."_id",self::$account->id)->get();
            foreach($lastDefaultMyAddresss as $myAddress){
                myaddress::createUpdate([
                    "id"       =>$myAddress->id,
                    "isDefult" =>0
                ]);
            }
        }
        $record=  myaddress::createUpdate([
            "id"         =>self::$request->locationId,
            "users_id"   =>self::$account->id,
            "longitude"  =>self::$request->location["longitude"],
            "latitude"   =>self::$request->location["latitude"],
            "address"    =>self::$request->location["address"],
            "isDefult"   =>self::$request->isDefaultAddress,
            "description"=>self::$request->description,
        ]);
        return [
            "status"=>200,
            "location"=>$record
        ];
    }
}

