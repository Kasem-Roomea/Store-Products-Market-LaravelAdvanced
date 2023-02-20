<?php

namespace App\Http\Controllers\Apis\Controllers\getDays;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\days;

class getDaysController extends index
{
    public static function api(){

        $records=  days::all();
        return [
            "status"=>200,
            "days"=>objects::ArrayOfObjects($records->forPage(self::$request->page+1,self::$itemPerPage),"day"),
        ];
    }
}