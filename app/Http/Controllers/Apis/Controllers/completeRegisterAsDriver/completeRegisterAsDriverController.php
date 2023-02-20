<?php

namespace App\Http\Controllers\Apis\Controllers\completeRegisterAsDriver;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\users;

class completeRegisterAsDriverController extends index
{
    public static function api(){

        $record= users::createUpdate([
            "id"                        =>self::$account->id,
            "vehicles_id"               =>self::$request->vehicleId,
            "frontIdImage"              =>self::$request->frontIdImage,
            "rearIdImage"               =>self::$request->rearIdImage,
            "frontDrivingLicenseImage"  =>self::$request->frontDrivingLicenseImage,
            "rearDrivingLicenseImage"   =>self::$request->rearDrivingLicenseImage,
            "frontVehicleLicenseImage"  =>self::$request->frontVehicleLicenseImage,
            "rearVehicleLicenseImage"   =>self::$request->rearVehicleLicenseImage,
            "frontVehicleImage"         =>self::$request->frontVehicleImage,
            "rearVehicleImage"          =>self::$request->rearVehicleImage,
            "isDriver"                  =>1,
            "driverBalance"             =>0,
            "isOnline"                  =>0,
            "isDriverApproved"          =>0
             
            ]);
        return [
            "status"=>200,
            "account"=> $record,
            "message"=>self::$messages["register"]["201"]
        ];
    }
}