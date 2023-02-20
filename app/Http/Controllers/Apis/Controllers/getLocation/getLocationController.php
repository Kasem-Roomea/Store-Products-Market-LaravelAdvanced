<?php
namespace App\Http\Controllers\Apis\Controllers\getLocation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use Illuminate\Support\Str;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\locations;
use App\Models\users;
use App\Models\providers;
use App\Models\shops;

class getLocationController extends index
{
    public static function api(){

        // $table='App\Models\\'.Str::plural(self::$request->type);
        // if(!$table::find(self::$request->targetId)){
        //     return [
        //         "status"=>405,
        //         "message"=>"error in targetId"
        //     ];
        // }
        return [
            "status"=>200,
            "locations"=>objects::location(self::$account->location),
        ];
    }
}