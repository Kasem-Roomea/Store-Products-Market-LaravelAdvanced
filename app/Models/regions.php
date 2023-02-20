<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Apis\Helper\helper ;
class regions extends Model
{

    protected 
    $table = 'regions',$appends=['name','country_name','city_name','city','country','type_lang'] ;
    public $guarded = [];
    public $timestamps = false;
    public static function createUpdate($params){

        $record= isset($params['id'])? self::find($params['id']) :new self();
        $record->nameAr =isset($params['nameAr'])?$params['nameAr']: $record->nameAr;
        $record->nameEn =isset($params['nameEn'])?$params['nameEn']: $record->nameEn;
        $record->type =isset($params['rdio'])?$params['rdio']: $record->type;
        $record->regions_id	= $params['regions_id'] ?? $record->regions_id	;
        isset($params['id'])?:$record->createdAt = date("Y-m-d H:i:s");
        $record->save();
        return $record;
    }

    function cityEmirateParent(){
        return $this->belongsTo('App\Models\regions' , 'regions_id' , 'id' );
    }
    
    public function region(){   
        return $this->belongsTo(regions::class,'regions_id');
    }
    public function regions(){   
        return $this->hasMany(regions::class,'regions_id');
    }

    function GetCountryNameAttribute(){
        if (!$this->region)
            return null;
        elseif(!$this->region->region)
            return $this->region->name;
        else 
            return $this->region->region->name;  
    }
    function GetTypeLangAttribute(){
        $type=['Ar'=>["city"=>'مدينة','emirate'=>'إمارة','district'=>'منطقة'],
                'En'=>["city"=>'city','emirate'=>'emirate','district'=>'district']];
        return $type[\Session()->get('local')][$this->attributes['type']];
    }
    function GetCityNameAttribute(){
        if(!$this->region)
            return null;
        elseif(!$this->region->region)
            return null;
        else 
            return $this->region->name; 

    }
    function GetNameAttribute(){
        $name = 'name'.self::$lang;
        return $this->$name;
    }
    function GetCityAttribute(){
        if ($this->type== 'district')
            return  $this->region;
    }
    function GetCountryAttribute(){
        if ($this->type== 'city')
            return  $this->region;
    }
}