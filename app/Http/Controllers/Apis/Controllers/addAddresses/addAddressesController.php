<?php

namespace App\Http\Controllers\Apis\Controllers\addAddresses;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\myAddress;
class addAddressesController extends index
{
    public static function api()
    {
        $record=  myaddress::updateOrCreate(['id'=>self::$request->locationId],[
            "users_id"=>self::$account->id,
            "longitude"=>self::$request->location["longitude"],
            "latitude"=>self::$request->location["latitude"],
            "address"=>self::$request->location["address"],
            "isDefult"=>self::$request->isDefaultAddress,
            "description"=>self::$request->description,
            'createdAt'=>now(),  

        ]);

        if(self::$request->has("isDefaultAddress")){
            myAddress::where(self::$account->getTable()."_id",self::$account->id)
                        ->where('id','!=',$record->id)
                        ->update(['isDefult'=>0]);
        }

        return [
            "status"=>200,
            "location"=>objects::location($record),
            'message'=>self::$messages['address'][self::$request->locationId?202:200]
        ];
    }
}