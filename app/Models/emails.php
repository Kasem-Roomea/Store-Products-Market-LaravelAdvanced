<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class emails extends GeneralModel
{
    protected $table = 'emails';

    public static function createUpdate($params){

        $record= isset($params["id"])? self::find($params["id"]) :new self();
        $record->email = isset($params["email"])? $params["email"]: $record->email;
        $record->appInfo_id = isset($params["appInfo_id"])? $params["appInfo_id"]: $record->appInfo_id;
        $record->shops_id = isset($params["shops_id"])? $params["shops_id"]: $record->shops_id;
        $record->deletedAt = isset($params["deletedAt"])? date("Y-m-d H:i:s"):null;
        $record->save();
        return $record;
    }
    public function ModelName1(){
        return $this->belongsTo("\App\Models\ModelName1","ModelName1_id");
    }
    public function ModelName2(){
        return $this->hasMany("\App\Models\ModelName2",'emails_id');
    }
}