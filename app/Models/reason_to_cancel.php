<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class reason_to_cancel extends GeneralModel
{
    protected $table = 'reason_to_cancel';

    public static function createUpdate($params){

        $record= isset($params["id"])? self::find($params["id"]) :new self();
        $record->reason = isset($params["reason"])? $params["reason"]: $record->reason;
        $record->deletedAt = isset($params["deletedAt"])? date("Y-m-d H:i:s"):null;
        $record->save();
        return $record;
    }
}