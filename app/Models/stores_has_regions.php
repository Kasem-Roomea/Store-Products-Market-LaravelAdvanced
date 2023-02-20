<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class stores_has_regions extends GeneralModel
{
    protected $table = 'stores_has_regions',$fillable = ['regions_id','stores_id'];
    public static function createUpdate($params){

        $record= isset($params["id"])? self::find($params["id"]) :new self();
        $record->stores_id = isset($params["stores_id"])? $params["stores_id"]: $record->stores_id;
        $record->regions_id = isset($params["regions_id"])? $params["regions_id"]: $record->regions_id;
        $record->save();
        return $record;
    }
    public function store(){
        return $this->belongsTo(stores::class);
    }
    public function region(){
        return $this->belongsTo(region::class);
    }
}