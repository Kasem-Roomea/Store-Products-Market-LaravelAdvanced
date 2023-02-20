<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class logs extends GeneralModel
{
    protected $table = 'logs',$with=['user'];

    public static function createUpdate($params){

        $record= isset($params["id"])? self::find($params["id"]) :new self();
        $record->balance = isset($params["balance"])? $params["balance"]: $record->balance;
        $record->users_id = isset($params["users_id"])? $params["users_id"]: $record->users_id;
        $record->drivers_id = isset($params["drivers_id"])? $params["drivers_id"]: $record->drivers_id;
        $record->stores_id = isset($params["stores_id"])? $params["stores_id"]: $record->stores_id;
        $record->admins_id = isset($params["admins_id"])? $params["admins_id"]: $record->admins_id;
        isset($params["id"])?:$record->createdAt = date("Y-m-d H:i:s");
        $record->save();
        return $record;
    }
    public function user(){
        return $this->belongsTo(users::class,"users_id");
    }
}