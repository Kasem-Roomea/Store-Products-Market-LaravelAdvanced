<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Apis\Helper\helper ;

class features extends GeneralModel
{
    protected $table = 'features';

    public static function createUpdate($params){

        $record= isset($params["id"])? self::find($params["id"]) :new self();
        $record->nameAr = isset($params["nameAr"])? $params["nameAr"]: $record->nameAr;
        $record->nameEn = isset($params["nameEn"])? $params["nameEn"]: $record->nameEn;
        $record->price = isset($params["price"])? $params["price"]: $record->price;
        $record->products_id = isset($params["products_id"])? $params["products_id"]: $record->products_id;
        $record->image = isset($params["image"])?helper::uploadPhoto( $params["image"],'features'): $record->image;
        $record->save();
        return $record;
    }
}