<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class drivers_registration_terms extends GeneralModel
{
    protected $table = 'drivers_registration_terms';

    public static function createUpdate($params){

        $record= isset($params["id"])? self::find($params["id"]) :new self();
        $record->colName = isset($params["colName"])? $params["colName"]: $record->colName;
        $record->image = isset($params["image"])?helper::base64_image( $params["image"],'drivers_registration_terms'): $record->image;
        $record->deleted_at = isset($params["deleted_at"])? date("Y-m-d H:i:s"):null;
        isset($params["id"])?:$record->created_at = date("Y-m-d H:i:s");
        !isset($params["id"])?:$record->updated_at = date("Y-m-d H:i:s");
        $record->save();
        return $record;
    }
    public function ModelName1(){
        return $this->belongsTo("\App\Models\ModelName1","ModelName1_id");
    }
    public function ModelName2(){
        return $this->hasMany("\App\Models\ModelName2",'drivers_registration_terms_id');
    }
}