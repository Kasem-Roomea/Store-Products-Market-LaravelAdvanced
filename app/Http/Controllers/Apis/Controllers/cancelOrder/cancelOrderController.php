<?php

namespace App\Http\Controllers\Apis\Controllers\cancelOrder;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\orders;
use App\Models\driver_cancel_orders;
use App\Http\Controllers\Apis\Controllers\sendToDeliveries\sendToDeliveriesController;

class cancelOrderController extends index
{
    public static function api()
    {
        $record =  orders::find(self::$request->orderId);
        driver_cancel_orders::updateOrCreate([
            "orders_id" => $record->id,
            "drivers_id" => self::$account->id,
        ], [
            'created_at' => now()
        ]);

        helper::SocketUser($record->users_id, 'cancelOrder', objects::order($record));
        helper::newNotify(
            [$record->user],
            self::$messagesAll["Ar"]["notifications"]["refueseOrder"],
            self::$messagesAll["En"]["notifications"]["refueseOrder"],
            $record->id
        );

        helper::SocketStore($record->stores_id, 'cancelOrder', objects::order($record));
        helper::newNotify(
            [$record->store],
            self::$messagesAll["Ar"]["notifications"]["refueseOrder"],
            self::$messagesAll["En"]["notifications"]["refueseOrder"],
            $record->id
        );
        self::sendToDeliveriesAgain($record);
        return [
            "status" => 200,
        ];
    }
    static function sendToDeliveriesAgain($record)
    {
        self::$account = $record->store;
        sendToDeliveriesController::api();
    }
}
