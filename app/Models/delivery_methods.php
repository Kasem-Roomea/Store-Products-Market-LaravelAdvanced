<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class delivery_methods extends GeneralModel
{
    protected $table = 'delivery_methods';

    public static function createUpdate($params){

        $record= isset($params["id"])? self::find($params["id"]) :new self();
        $record->name_ar = isset($params["name_ar"])? $params["name_ar"]: $record->name_ar;
        $record->name_en = isset($params["name_en"])? $params["name_en"]: $record->name_en;
        $record->save();
        return $record;
    }
}