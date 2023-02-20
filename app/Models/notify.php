<?php

namespace App\Models;

use App\Http\Controllers\Apis\Controllers\index;
use Illuminate\Database\Eloquent\Model;

class notify extends Model
{
    protected $table = 'notify';
    protected $guarded = [];
    public $timestamps = false;

    public static function createUpdate($params)
    {

        $record = isset($params['id']) ? self::find($params['id']) : new self();
        $record->notifications_id = isset($params['notifications_id']) ? $params['notifications_id'] : $record->notifications_id;
        $record->isSeen     = isset($params['isSeen']) ? $params['isSeen'] : $record->isSeen;
        $record->users_id   = isset($params['users_id']) ? $params['users_id'] : $record->users_id;
        $record->stores_id  = isset($params['stores_id']) ? $params['stores_id'] : $record->stores_id;
        $record->drivers_id = isset($params['drivers_id']) ? $params['drivers_id'] : $record->drivers_id;
        $record->reviews_id = isset($params['reviews_id']) ? $params['reviews_id'] : $record->reviews_id;
        $record->orders_id  = isset($params['orders_id']) ? $params['orders_id'] : $record->orders_id;
        $record->offers_id  = isset($params['offers_id']) ? $params['offers_id'] : $record->offers_id;
        $record->bills_id   = isset($params['bills_id']) ? $params['bills_id'] : $record->bills_id;
        $record->code       = isset($params['code']) ? $params['code'] : $record->code;
        isset($params['id']) ?: $record->createdAt = date("Y-m-d H:i:s");
        $record->save();
        return $record;
    }

    public function notification()
    {
        return $this->belongsTo(notifications::class, 'notifications_id');
    }

    public function product()
    {
        return $this->belongsTo(products::class, 'products_id');
    }

    public function offer()
    {
        return $this->belongsTo(offers::class, 'offers_id');
    }
    public function user()
    {
        return $this->belongsTo(users::class, 'users_id');
    }
    public function driver()
    {
        return $this->belongsTo(drivers::class, 'drivers_id');
    }
    public function store()
    {
        return $this->belongsTo(stores::class, 'stores_id');
    }
    public function order()
    {
        return $this->belongsTo(orders::class, 'orders_id');
    }
    function GetContentAttribute()
    {
        return $this->notification['content' . $this->target_user->language ?? 'Ar'];
    }
    function GetTitleAttribute()
    {
        return $this->notification['title' . $this->target_user->language ?? 'Ar'];
    }
    function GetTargetUserAttribute()
    {
        if ($this->user)
            return $this->user;
        if ($this->driver)
            return $this->driver;
        if ($this->store)
            return $this->store;
    }



    //العلاقة بين الاشعارات وعرض الاشعارات
    public function notificationsViewUsers()
    {
        return $this->belongsTo('App\Model\notification','notifications_id ' , 'id');
    }

    //العلاقة بين الاشعارات والمستخدمين
    public function userNotification()
    {
        return $this->belongsTo('App\Model\User','users_id ' , 'id');
    }

    //العلاقة بين الاشعارات والسائقين
    public function driversNotification()
    {
        return $this->belongsTo('App\Model\driver','drivers_id ' , 'id');
    }

    //العلاقة بين الاشعارات المتاجر
    public function storesNotification()
    {
        return $this->belongsTo('App\Model\store','stores_id ' , 'id');
    }
}
