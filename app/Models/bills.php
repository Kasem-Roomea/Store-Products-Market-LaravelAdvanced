<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class bills extends Model
{
    public $table = 'bills',$appends=["billDetails"],$guarded=[],$timestamps=false;

    public static function createUpdate($params){

        $record= isset($params["id"])? self::find($params["id"]) :new self();
        $record->deliveryPrice = isset($params["deliveryPrice"])? $params["deliveryPrice"]: $record->deliveryPrice;
        $record->products_price = isset($params["products_price"])? $params["products_price"]: $record->products_price;
        $record->totalPrice = isset($params["totalPrice"])? $params["totalPrice"]: $record->totalPrice;
        $record->orders_id = isset($params["orders_id"])? $params["orders_id"]: $record->orders_id;
        $record->driverFees = isset($params["driverFees"])? $params["driverFees"]: $record->driverFees;
        $record->discounted = isset($params["discounted"])? $params["discounted"]: $record->discounted;
        $record->storeFees = isset($params["storeFees"])? $params["storeFees"]: $record->storeFees;
        $record->deletedAt = isset($params["deletedAt"])? date("Y-m-d H:i:s"):null;
        isset($params["id"])?:$record->createdAt = date("Y-m-d H:i:s");
        $record->save();
        return $record;
    }
    public function order(){
        return $this->belongsTo(orders::class,"orders_id");
    }
    function GetBillDetailsAttribute(){
        return bills_details::where('bills_id',$this->id)->get();
    }

}