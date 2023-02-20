<?php
namespace App\Http\Controllers\Apis\Controllers\getMyCart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\carts;
use App\Models\products;
use App\Services\makeOrderService;

class getMyCartController extends index
{
    public static function api()
    {
        $records= carts::where('orders_id',null)
                        ->where('users_id',self::$account->id)
                        ->get();
        
        return [
            "status"=>$records->count()?200:204,
            'totalPrice'=>makeOrderService::totalInCart(),
            "totalPages"=>ceil($records->count()/self::$itemPerPage),
            "carts"=>objects::ArrayOfObjects($records,"cart"),
        ];
    }
}