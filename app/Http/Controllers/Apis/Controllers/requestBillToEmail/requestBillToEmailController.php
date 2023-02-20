<?php

namespace App\Http\Controllers\Apis\Controllers\requestBillToEmail;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\ModelName;

class requestBillToEmailController extends index
{
    public static function api(){

        return [
            "status"=>200,
        ];
    }
}