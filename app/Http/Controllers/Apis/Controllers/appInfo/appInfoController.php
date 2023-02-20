<?php
namespace App\Http\Controllers\Apis\Controllers\appInfo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper ;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\appInfo;

class appInfoController extends index
{
    public static function api()
    {
        $records =  appInfo::first();
        return [
            "status"=>200,
            "appInfo"=>objects::AppInfo($records),
        ];
    }
}