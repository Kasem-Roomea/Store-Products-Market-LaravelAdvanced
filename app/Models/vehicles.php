<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class vehicles extends GeneralModel
{
    protected $table = 'vehicles';

    public static function createUpdate($params){

        $record= isset($params["id"])? self::find($params["id"]) :new self();
        $record->nameAr = isset($params["nameAr"])? $params["nameAr"]: $record->nameAr;
        $record->nameEn = isset($params["nameEr"])? $params["nameEr"]: $record->nameEn;
        $record->isActive = isset($params["isActive"])? $params["isActive"]: $record->isActive;
        isset($params["id"])?:$record->createdAt = date("Y-m-d H:i:s");
        $record->save();
        return $record;
    }
}