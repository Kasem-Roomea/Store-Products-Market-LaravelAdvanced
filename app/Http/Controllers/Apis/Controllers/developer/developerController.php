<?php

namespace App\Http\Controllers\Apis\Controllers\developer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\ModelName;

class developerController extends index
{
    public static function api(){

        if(self::$request->has('objects')){
            $result= include('resources.php');
            $result = isset($result[self::$request->objects])?$result[self::$request->objects]:$result;
        }elseif(self::$request->has('type')){
            $result= include('apis.php');
            $result= $result[self::$request->type];
            $result = isset($result[self::$request->page])?$result[self::$request->page]:$result;
        }else{
            return abort(403);
        }

        return $result;
    }
}