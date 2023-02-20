<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class messages extends GeneralModel
{
    protected $table = 'messages';

    public static function createUpdate($params){

        $record= isset($params["id"])? self::find($params["id"]) :new self();
        $record->type = isset($params["type"])? $params["type"]: $record->type;
        $record->message = isset($params["message"])? $params["message"]: $record->message;
        $record->isSeen = isset($params["isSeen"])? $params["isSeen"]: $record->isSeen;
        $record->rooms_id = isset($params["rooms_id"])? $params["rooms_id"]: $record->rooms_id;
        $record->providers_id = isset($params["providers_id"])? $params["providers_id"]: $record->providers_id;
        $record->users_id = isset($params["users_id"])? $params["users_id"]: $record->users_id;
        $record->drivers_id = isset($params["drivers_id"])? $params["drivers_id"]: $record->drivers_id;
        $record->orders_id = isset($params["orders_id"])? $params["orders_id"]: $record->orders_id;
        $record->image = isset($params["image"])?helper::base64_image( $params["image"],'messages'): $record->image;
        $record->voice = isset($params["voice"])?helper::base64_image( $params["voice"],'messages'): $record->voice;
        $record->video = isset($params["video"])?helper::base64_image( $params["video"],'messages'): $record->video;
        $record->deletedAt = isset($params["deletedAt"])? date("Y-m-d H:i:s"):null;
        isset($params["id"])?:$record->createdAt = date("Y-m-d H:i:s");
        $record->save();
        return $record;
    }
    public function ModelName1(){
        return $this->belongsTo("\App\Models\ModelName1","ModelName1_id");
    }
    public function ModelName2(){
        return $this->hasMany("\App\Models\ModelName2",'messages_id');
    }
}