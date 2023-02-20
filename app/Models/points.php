<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Apis\Helper\helper ;

class points extends GeneralModel
{
    protected $table = 'points';

    public static function createUpdate($params){

        $record= isset($params["id"])? self::find($params["id"]) :new self();
        $record->numberOfPoints = isset($params["numberOfPoints"])? $params["numberOfPoints"]: $record->numberOfPoints;
        $record->descriptionAr = isset($params["descriptionAr"])? $params["descriptionAr"]: $record->descriptionAr;
        $record->descriptionEn = isset($params["descriptionEn"])? $params["descriptionEn"]: $record->descriptionEn;
        $record->image =isset($params['image'])?helper::base64_image_dash( $params['image'],'users'): $record->image;
        $record->save();
        return $record;
    }
    public function ModelName1(){
        return $this->belongsTo("\App\Models\ModelName1","ModelName1_id");
    }
    public function ModelName2(){
        return $this->hasMany("\App\Models\ModelName2",'points_id');
    }
}