<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class favorites extends GeneralModel
{
    protected $table = 'favorites';

    public static function createUpdate($params){

        $record= isset($params["id"])? self::find($params["id"]) :new self();
        $record->users_id = isset($params["users_id"])? $params["users_id"]: $record->users_id;
        $record->products_id = isset($params["products_id"])? $params["products_id"]: $record->products_id;
        $record->save();
        return $record;
    }
    public function product(){
        return $this->belongsTo(products::class,"products_id");
    }
}