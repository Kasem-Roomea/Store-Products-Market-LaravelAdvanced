<?php

namespace App\Http\Controllers\Apis\Controllers\acceptedByDriver;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\orders;
use App\Models\bills;
use App\Models\drivers;
use App\Models\appInfo;

class acceptedByDriverController extends index
{
    public static function api()
    {
        $record =  orders::find(self::$request->orderId);
        orders::createUpdate([
            "id" => $record->id,
            "status" => "processing",
            "drivers_id" => self::$account->id
        ]);
        error_log($record->user);
        helper::SocketUser($record->users_id, 'acceptedByDriver', objects::order($record));
        helper::newNotify(
            [$record->user],
            self::$messagesAll["Ar"]["notifications"]["acceptedByDriver"],
            self::$messagesAll["En"]["notifications"]["acceptedByDriver"],
            $record->id
        );

        helper::SocketStore($record->stores_id, 'acceptedByDriver', objects::order($record));
        helper::newNotify(
            [$record->store],
            self::$messagesAll["Ar"]["notifications"]["acceptedByDriver"],
            self::$messagesAll["En"]["notifications"]["acceptedByDriver"],
            $record->id
        );
        $driver = drivers::find(self::$account->id);
        $driverFees = $record->deliveryPrice / 100 * $driver->fees ?? appInfo::first()->driverFees;
        bills::createUpdate([
            "id" => bills::where("orders_id", self::$request->orderId)->first()->id,
            "driverFees" => $driverFees,
        ]);
        $driver->balance -= $driverFees;
        $driver->save();
        return [
            "status" => 200,
        ];
    }
}
