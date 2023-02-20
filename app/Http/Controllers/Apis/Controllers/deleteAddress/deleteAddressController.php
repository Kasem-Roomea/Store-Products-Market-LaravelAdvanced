<?php
namespace App\Http\Controllers\Apis\Controllers\deleteAddress;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\myAddress;

class deleteAddressController extends index
{
    public static function api(){

        $record=  myAddress::destroy(self::$request->locationId);
        return [
            "status"=>200,
            'message'=>self::$messages['address'][201]

        ];
    }
}