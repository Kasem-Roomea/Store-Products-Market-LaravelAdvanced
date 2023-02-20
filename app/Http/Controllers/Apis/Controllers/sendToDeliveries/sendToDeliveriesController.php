<?php

namespace App\Http\Controllers\Apis\Controllers\sendToDeliveries;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\orders;
use App\Models\drivers;
use App\Models\driver_cancel_orders;

class sendToDeliveriesController extends index
{
    public static function api()
    {
        $record =  orders::find(self::$request->orderId);
        if ($record->stores_id  && $record->stores_id != self::$account->id)
            return [
                'status' => 418,
                "message" => self::$messages['order']["418"]
            ];
        error_log('yyy ' . self::$account);
        orders::createUpdate([
            "id" => $record->id,
            "status" => "progressing",
            'stores_id' => self::$account->id
        ]);
        $drivers = drivers::where("isVerified", 1)
            ->where('isActive', 1)
            ->whereNotIn('id', driver_cancel_orders::where('orders_id', self::$request->orderId)->pluck('drivers_id')->toArray())
            ->get();
        foreach ($drivers as $driver) {
            helper::SocketDriver($driver->id, 'sendToDeliveries', objects::order($record));
        }
        helper::newNotify($drivers, self::$messagesAll["Ar"]["notifications"]["sendToDeliveries"], self::$messagesAll["En"]["notifications"]["sendToDeliveries"], $record->id);

        // send To Deliveries
        helper::newNotify(
            [$record->user],
            self::$messagesAll["Ar"]["notifications"]["waitingOrderForAccepting"],
            self::$messagesAll["En"]["notifications"]["waitingOrderForAccepting"],
            $record->id
        );
        helper::SocketUser($record->users_id, 'waitingOrderForAccepting',  $record);

        return [
            "status" => 200,
        ];
    }
}
