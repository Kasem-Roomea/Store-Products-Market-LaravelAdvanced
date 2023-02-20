<?php

namespace App\Http\Controllers\Apis\Controllers\editCart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\carts;
use App\Models\products;
use App\Models\prices;
use App\Services\makeOrderService;

class editCartController extends index
{
    public static function api()
    {
        $cart = carts::where('id', self::$request->cartId)
            ->where('users_id', self::$account->id)
            ->firstOrFail();


        $product = products::find($cart->products_id);
        if ($product->quantity < self::$request->quantity) {
            return [
                "status" => 430,
                "notAvailable" => [
                    'product' => objects::product($product),
                    'availableQuantity' => $product->quantity
                ],
                "message" => self::$messages['order']["430"]
            ];
        }
        $quantity = self::$request->quantity;
        $price = $product->price;
        if (self::$request->priceId) {
            $priceRecord = prices::find(self::$request->priceId);
            $total_quantity = $priceRecord->quantity * $quantity;
            $price = $priceRecord->price;
        }

        $offer = 0;
        if ($product->offers->first()) {
            $offer = $product->offers->first()->discount / 100 ?? 0;
        }
        $price = $price - $price * $offer;

        $cart->update([
            'quantity' => $quantity,
            'price' => $price,
            'total_quantity' => $total_quantity ?? $quantity,

        ]);
        return [
            'totalPrice' => makeOrderService::totalInCart(),
            "status" => 200,
        ];
    }
}
