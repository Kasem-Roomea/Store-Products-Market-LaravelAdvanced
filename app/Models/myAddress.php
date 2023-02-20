<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class myAddress extends Model
{
    protected $table = 'myAddress';
    public $guarded=[],$timestamps=false;
    public static function createUpdate($params){

        $record= isset($params["id"])? self::find($params["id"]) :new self();
        $record->latitude = isset($params["latitude"])? $params["latitude"]: $record->latitude;
        $record->longitude = isset($params["longitude"])? $params["longitude"]: $record->longitude;
        $record->address = isset($params["address"])? $params["address"]: $record->address;
        $record->description = isset($params["description"])? $params["description"]: $record->description;
        $record->isDefult = isset($params["isDefult"])? $params["isDefult"]: $record->isDefult;
        $record->providers_id = isset($params["providers_id"])? $params["providers_id"]: $record->providers_id;
        $record->users_id = isset($params["users_id"])? $params["users_id"]: $record->users_id;
        isset($params["id"])?:$record->createdAt = date("Y-m-d H:i:s");
        $record->save();
        return $record;
    }   
    public function user(){
        return $this->belongsTo(users::class,"users_id");
    }
}