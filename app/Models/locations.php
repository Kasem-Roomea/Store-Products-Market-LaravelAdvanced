<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class locations extends GeneralModel
{
    protected $table = 'locations';

    public static function createUpdate($params)
    {

        $record = isset($params["id"]) ? self::find($params["id"]) : new self();
        $record->latitude = isset($params["latitude"]) ? $params["latitude"] : $record->latitude;
        $record->longitude = isset($params["longitude"]) ? $params["longitude"] : $record->longitude;
        $record->address = isset($params["address"]) ? $params["address"] : $record->address;
        $record->description = isset($params["description"]) ? $params["description"] : $record->description;
        $record->providers_id = isset($params["providers_id"]) ? $params["providers_id"] : $record->providers_id;
        $record->users_id = isset($params["users_id"]) ? $params["users_id"] : $record->users_id;
        $record->stores_id = isset($params["stores_id"]) ? $params["stores_id"] : $record->stores_id;
        $record->mapUrl = isset($params["mapUrl"]) ? $params["mapUrl"] : $record->mapUrl;
        $record->deletedAt = isset($params["deletedAt"]) ? date("Y-m-d H:i:s") : null;
        $record->save();
        return $record;
    }
    public function provider()
    {
        return $this->belongsTo(providers::class, "providers_id");
    }
    public function user()
    {
        return $this->belongsTo(users::class, "users_id");
    }
    public function shop()
    {
        return $this->belongsTo(stores::class, "stores_id");
    }
}
