<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Apis\Helper\helper ;

class carts extends Model
{
    protected $table = 'carts',$appends=["features",'points'];
    public $guarded=[],$timestamps=false;

    public static function createUpdate($params)
    {
        $record= isset($params["id"])? self::find($params["id"]) :new self();
        $record->orders_id = isset($params["orders_id"])? $params["orders_id"]: $record->orders_id;
        $record->products_id = isset($params["products_id"])? $params["products_id"]: $record->products_id;
        $record->quantity = isset($params["quantity"])? $params["quantity"]: $record->quantity;
        $record->description = isset($params["description"])? $params["description"]: $record->description;
        $record->deletedAt = isset($params["deletedAt"])? date("Y-m-d H:i:s"):null;
        isset($params["id"])?:$record->createdAt = date("Y-m-d H:i:s");
        $record->save();
        return $record;
    }
    public function product()
    {
        return $this->belongsTo(products::class,"products_id");
    }
    public function GetFeaturesAttribute(){
        $featuresIds = features_in_carts::where("carts_id",$this->id)->pluck("features_id");
        if(count($featuresIds))
            return [];
        return features::whereIn("id",$featuresIds)->get();
    }
    public function features_in_carts()
    {
        return $this->hasMany(features_in_carts::class,"carts_id");
    }
    function GetPointsAttribute()
    {
        return $this->product->points * $this->quantity;
    }
}