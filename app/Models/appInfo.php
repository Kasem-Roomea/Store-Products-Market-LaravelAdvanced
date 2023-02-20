<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class appInfo extends GeneralModel
{
    protected $table = 'appInfo';
    protected $guarded = [];

    public static function createUpdate($params){
        $record= isset($params["id"])? self::find($params["id"]) :new self();
        $record->welcomeAr = isset($params["welcomeAr"])? $params["welcomeAr"]: $record->welcomeAr;
        $record->welcomeEn = isset($params["welcomeEn"])? $params["welcomeEn"]: $record->welcomeEn;
        $record->aboutAr = isset($params["aboutAr"])? $params["aboutAr"]: $record->aboutAr;
        $record->aboutEn = isset($params["aboutEn"])? $params["aboutEn"]: $record->aboutEn;
        $record->policyAr = isset($params["policyAr"])? $params["policyAr"]: $record->policyAr;
        $record->policyEn = isset($params["policyEn"])? $params["policyEn"]: $record->policyEn;
        $record->privacyAr = isset($params["privacyAr"])? $params["privacyAr"]: $record->privacyAr;
        $record->privacyEn	 = isset($params["privacyEn	"])? $params["privacyEn	"]: $record->privacyEn	;
        $record->userFees = isset($params["userFees"])? $params["userFees"]: $record->userFees;
        $record->driverFees = isset($params["driverFees"])? $params["driverFees"]: $record->driverFees;
        $record->storeFees = isset($params["storeFees"])? $params["storeFees"]: $record->storeFees;
        $record->radius = isset($params["radius"])? $params["radius"]: $record->radius;
        $record->pricePer20Km = isset($params["pricePer20Km"])? $params["pricePer20Km"]: $record->pricePer20Km;
        $record->priceOfPoint = isset($params["priceOfPoint"])? $params["priceOfPoint"]: $record->priceOfPoint;
        $record->maxStorePoints = isset($params["maxStorePoints"])? $params["maxStorePoints"]: $record->maxStorePoints;
        $record->cashFees = isset($params["cashFees"])? $params["cashFees"]: $record->cashFees;
        $record->save();
        return $record;
    }
    public function phones(){
        return $this->hasMany(phones::class,'appInfo_id');
    }
    public function emails(){
        return $this->hasMany(emails::class,'appInfo_id');
    }
}