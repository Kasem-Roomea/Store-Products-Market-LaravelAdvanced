<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class code_used extends GeneralModel
{
    protected $table = 'code_used';

    public static function createUpdate($params){

        $record= isset($params["id"])? self::find($params["id"]) :new self();
        $record->codes_id = isset($params["codes_id"])? $params["codes_id"]: $record->codes_id;
        $record->orders_id = isset($params["orders_id"])? $params["orders_id"]: $record->orders_id;
        $record->users_id = isset($params["users_id"])? $params["users_id"]: $record->users_id;
        $record->isUsed = isset($params["isUsed"])? $params["isUsed"]: $record->isUsed;
        $record->deletedAt = isset($params["deletedAt"])? date("Y-m-d H:i:s"):null;
        isset($params["id"])?:$record->createdAt = date("Y-m-d H:i:s");
        !isset($params["id"])?:$record->updatedAt = date("Y-m-d H:i:s");
        $record->save();
        return $record;
    }
    public function code(){
        return $this->belongsTo(codes::class,"codes_id");
    }
    public function order(){
        return $this->belongsTo(orders::class,"orders_id");
    }
    public function user(){
        return $this->belongsTo(users::class,"users_id");
    }
}