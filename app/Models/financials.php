<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class financials extends GeneralModel
{
    protected $table = 'financials';

    public static function createUpdate($params){

        $record= isset($params["id"])? self::find($params["id"]) :new self();
        $record->applicationFees = isset($params["applicationFees"])? $params["applicationFees"]: $record->applicationFees;
        $record->totalBenefit = isset($params["totalBenefit"])? $params["totalBenefit"]: $record->totalBenefit;
        $record->paidMoney = isset($params["paidMoney"])? $params["paidMoney"]: $record->paidMoney;
        $record->users_id = isset($params["users_id"])? $params["users_id"]: $record->users_id;
        $record->drivers_id = isset($params["drivers_id"])? $params["drivers_id"]: $record->drivers_id;
        $record->deletedAt = isset($params["deletedAt"])? date("Y-m-d H:i:s"):null;
        isset($params["id"])?:$record->createdAt = date("Y-m-d H:i:s");
        !isset($params["id"])?:$record->updatedAt = date("Y-m-d H:i:s");
        $record->save();
        return $record;
    }
    public function user(){
        return $this->belongsTo(users::class,"users_id");
    }
    public function driver(){
        return $this->belongsTo(users::class,"drivers_id");
    }
}