<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class features_in_carts extends GeneralModel
{
    protected $table = 'features_in_carts';

    public static function createUpdate($params){

        $record= isset($params["id"])? self::find($params["id"]) :new self();
        $record->carts_id  = isset($params["carts_id"])? $params["carts_id"]: $record->carts_id ;
        $record->features_id   = isset($params["features_id"])? $params["features_id"]: $record->features_id ;
        $record->save();
        return $record;
    }
    public function feature()
    {
        return $this->belongsTo(features::class,"features_id")   ;
    }
    
}