<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class reviews extends GeneralModel
{
    protected $table = 'reviews';

    public static function createUpdate($params)
    {
        $record= isset($params["id"])? self::find($params["id"]) :new self();
        $record->type = isset($params["type"])? $params["type"]: $record->type;
        $record->rate = isset($params["rate"])? $params["rate"]: $record->rate;
        $record->comment = isset($params["comment"])? $params["comment"]: $record->comment;
        $record->stores_id = isset($params["stores_id"])? $params["stores_id"]: $record->stores_id;
        $record->products_id = isset($params["products_id"])? $params["products_id"]: $record->products_id;
        $record->orders_id = isset($params["orders_id"])? $params["orders_id"]: $record->orders_id;
        $record->users_id = isset($params["users_id"])? $params["users_id"]: $record->users_id;
        $record->drivers_id = isset($params["drivers_id"])? $params["drivers_id"]: $record->drivers_id;
        isset($params["id"])?:$record->createdAt = date("Y-m-d H:i:s");
        $record->save();
        return $record;
    }
    public function shop(){
        return $this->belongsTo(shops::class,"shops_id");
    }
    public function product(){
        return $this->belongsTo(products::class,"products_id");
    }
    public function provider(){
        return $this->belongsTo(providers::class,"providers_id");
    }
    public function user(){
        return $this->belongsTo(users::class,"users_id");
    }
}