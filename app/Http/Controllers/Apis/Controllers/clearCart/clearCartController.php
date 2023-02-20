<?php
namespace App\Http\Controllers\Apis\Controllers\clearCart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\carts;
use App\Models\products;

class clearCartController extends index
{
    public static function api()
    {
        carts::where('users_id',self::$account->id)->where('orders_id',null)->delete();
        return [
            "status"=>200,
        ];
    }
}