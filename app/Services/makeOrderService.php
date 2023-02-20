<?php

namespace App\Services;

use App\Models\products;
use App\Models\orders;
use App\Models\users;
use App\Models\appInfo;
use App\Models\carts;
use App\Http\Controllers\Apis\Controllers\index;

class makeOrderService
{

    public static function incrementPoints($carts, users $account, appInfo $appInfo)
    {
        foreach ($carts as $cart) {
            error_log($cart->products_id);
            error_log(products::find($cart->products_id)->points);
            $account->increment(
                'points',
                products::find($cart->products_id)->points * $cart->total_quantity
            );
        }
        if (orders::where('users_id', $account->id)->count() == 1) {
            $account->increment('points', $appInfo->firstOrderPoints);
        }
    }
    public static function totalInCart(): float
    {
        $records = carts::where('orders_id', null)
            ->where('users_id', index::$account->id)
            ->get();

        $total =  $records->sum(function ($cart) {
            return $cart['quantity'] * $cart['price'];
        });
        return $total;
    }
}
