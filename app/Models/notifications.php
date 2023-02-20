<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Apis\Helper\helper ;

class notifications extends Model
{
    protected $table = 'notifications';
    protected $guarded = [];
    public $timestamps =false ;

    public static function createUpdate($params)
    {
        $record= isset($params['id'])? self::find($params['id']) :new self();
        $record->titleAr =  isset($params['titleAr'])?$params['titleAr']: $record->titleAr;
        $record->titleEn =  isset($params['titleEn'])?$params['titleEn']: $record->titleEn;
        $record->contentAr =  isset($params['contentAr'])?$params['contentAr']: $record->contentAr;
        $record->contentEn =  isset($params['contentEn'])?$params['contentEn']: $record->contentEn;
        $record->image =isset($params['image'])?helper::base64_image_dash( $params['image'],'notification'): $record->image;
        isset($params['id'])?:$record->createdAt = date("Y-m-d H:i:s");
        isset($params['deletedAt'])?:$record->deletedAt = date("Y-m-d H:i:s");
        $record->save();
        return $record;
    }
    
    public function notify(){
        return $this->hasMany('\App\Models\notify','notifications_id');
    }   


    public function countViews(){
        return $this->hasMany('\App\Models\notify','notifications_id')->where('isSeen','=',1)->count();
    }

}