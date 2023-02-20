<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class view_products extends GeneralModel
{
    protected $table = 'view_products';

    public static function createUpdate($params){

        $record= isset($params["id"])? self::find($params["id"]) :new self();
        $record->products_id = isset($params["products_id"])? $params["products_id"]: $record->products_id;
        $record->device_id = isset($params["device_id"])? $params["device_id"]: $record->device_id;
        $record->save();
        return $record;
    }
    public function product(){
        return $this->belongsTo(products::class,"products_id");
    }
  
}