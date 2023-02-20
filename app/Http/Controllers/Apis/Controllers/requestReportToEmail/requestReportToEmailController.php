<?php

namespace App\Http\Controllers\Apis\Controllers\requestReportToEmail;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\ModelName;

class requestReportToEmailController extends index
{
    public static function api(){

        return [
            "status"=>200,
        ];
    }
}