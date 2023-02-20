<?php

namespace App\Http\Controllers\Apis\Controllers\getOrders;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\orders;
use App\Models\driver_cancel_orders;

class getOrdersController extends index
{
    public static function api()
    {
        // $records=  orders::orderBy("id",)->where("online_payment_confirm",1);

        $records =  orders::orderBy("id", 'desc');
        // ->whereHas("order_online_payments");
        if (self::$account->getTable() == "users") {
            $records = $records->where(self::$account->getTable() . "_id", self::$account->id);
        } else {
            error_log(self::$account->id);
            $records = $records->whereNotIn('id', driver_cancel_orders::where('drivers_id', self::$account->id)->pluck('orders_id')->toArray());
        }

        $status = self::validateRequestStatus();
        if (self::$request->status) {
            $records = $records->whereIn('status', $status ?? ['waiting']);
        }
        if (self::$request->has('totalPrice')) {
            $records = $records->where('totalPrice', '>=', self::$request->totalPrice);
        }
        if (self::$request->has('date')) {
            $records = $records->where('created_at', '>=', self::$request->date);
        }
        if (self::$request->has('orderId')) {
            $records = $records->where('id', self::$request->orderId);
        }
        return [
            "status" => $records->forPage(self::$request->page + 1, self::$itemPerPage)->count() ? 200 : 204,
            "totalPages" => ceil($records->count() / self::$itemPerPage),
            "orders" => objects::ArrayOfObjects($records->forPage(self::$request->page + 1, self::$itemPerPage)->get(), "order"),
        ];
    }
    static function validateRequestStatus(): array
    {
        $status = [];
        $requestStatus = self::$request->status ?? ['waiting'];
        for ($i = 0; $i < count($requestStatus); $i++)
            if ($requestStatus[$i] == 'sentToDeliveries')
                $status[] = 'progressing';
            elseif ($requestStatus[$i] == 'acceptedByDriver')
                $status[] = 'processing';
            else
                $status[] = $requestStatus[$i];

        return $status;
    }
}
