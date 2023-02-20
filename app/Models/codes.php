<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class codes extends GeneralModel
{
    protected $table = 'codes';

    public static function createUpdate($params){

        $record= isset($params["id"])? self::find($params["id"]) :new self();
        $record->discount = isset($params["discount"])? $params["discount"]: $record->discount;
        $record->isActive = isset($params["isActive"])? $params["isActive"]: $record->isActive;
        $record->endDate = isset($params["endDate"])? $params["endDate"]: $record->endDate;
        $record->quantity = isset($params["quantity"])? $params["quantity"]: $record->quantity;
        $record->code = isset($params["id"])? $record->code : helper::UniqueRandomXDigits(6,'code',['codes']);
        $record->deletedAt = isset($params["deletedAt"])? date("Y-m-d H:i:s"):null;
        isset($params["id"])?:$record->createdAt = date("Y-m-d H:i:s");
        $record->save();
        return $record;
    }
}