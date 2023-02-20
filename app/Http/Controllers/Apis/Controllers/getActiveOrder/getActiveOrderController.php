<?php
namespace App\Http\Controllers\Apis\Controllers\getActiveOrder;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\orders;
use App\Models\offers;

class getActiveOrderController extends index
{
    public static function api()
    {
        $record=  orders::whereIn("status",["waiting",'accept'])
                        ->where("users_id",self::$account->id)
                        ->where(self::$account->getTable()."_id",self::$account->id)
                        ->first();
        return [
            "status"=>$record?200:204,
            "order"=>objects::order($record),
        ];
    }
}