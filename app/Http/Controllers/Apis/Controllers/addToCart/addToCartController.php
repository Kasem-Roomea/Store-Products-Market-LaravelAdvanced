<?php

namespace App\Http\Controllers\Apis\Controllers\addToCart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\carts;
use App\Models\prices;
use App\Models\products;
use App\Services\makeOrderService;

class addToCartController extends index
{
    public static function api()
    {
        $product = products::find(self::$request->productId);
        if ($product->quantity < 1) {
            return [
                "status" => 430,
                "notAvailable" => [
                    'product' => objects::product($product),
                    'availableQuantity' => $product->quantity

                ],
                "message" => self::$messages['order']["430"]
            ];
        }

        $cart = carts::where('products_id', $product->id)
            ->where('users_id', self::$account->id)
            ->where('orders_id', null)
            ->first();
        error_log($cart?->quantity);

        if (self::$request->quantity) {
            error_log("<<<<<<<<<<<<");
            $quantity = $cart?->quantity + self::$request->quantity;
        } else {
            error_log(">>>>>>>>>>");
            $quantity = $cart?->quantity + 1;
        }
        error_log($quantity);
        $price = $product->price;
        $offer = 0;
        if ($product->offers->first()) {
            $offer = $product->offers->first()->discount / 100 ?? 0;
        }
        error_log($offer);

        if (self::$request->priceId) {
            $priceRecord = prices::find(self::$request->priceId);
            $total_quantity = $priceRecord->quantity * $quantity;
            $price = $priceRecord->price;
            error_log($total_quantity);
        }

        $price = $price - $price * $offer;
        error_log($price);


        carts::updateOrCreate([
            'products_id' => $product->id,
            'users_id' => self::$account->id,
            'orders_id' => null,
        ], [
            'quantity' => $quantity,
            'price' => $price,
            'total_quantity' => $total_quantity ?? $quantity,
            'createdAt' => now()
        ]);
        return [
            "status" => 200,
            'totalPrice' => makeOrderService::totalInCart(),
            "message" => self::$messages['cart'][200]
        ];
    }
}
