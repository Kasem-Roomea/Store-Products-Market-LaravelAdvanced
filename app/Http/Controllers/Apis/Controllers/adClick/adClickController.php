<?php

namespace App\Http\Controllers\Apis\Controllers\adClick;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\ads;

class adClickController extends index
{
    public static function api(){

        $record=  ads::createUpdate([
            "id"=>self::$request->addId,
            "viewers"=>ads::find(self::$request->addId)->viewers+=1 
            ]);
        
        return [
            "status"=>200,
        ];
    }
}