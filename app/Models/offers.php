<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class offers extends Model
{
    use \App\Traits\Models\AllActiveOnly;

    protected   $table = 'offers',
        $guarded = [],
        $appends = ['type'],
        $with = [/*"product",*/"region", "category"];



    /*public function product(){
        return $this->belongsTo(products::class,"products_id");
    }*/

    public function products()
    {
        return $this->belongsTo('App\Models\products','products_id');
    }
    public function region()
    {
        return $this->belongsTo(regions::class, "regions_id");
    }
    public function category()
    {
        return $this->belongsTo(categories::class, "categories_id");
    }
    function GetTypeAttribute()
    {
        $Ar = ['category' => 'قسم', 'region' => 'منطقة', 'product' => 'منتج'];
        $En = ['category' => 'category', 'region' => 'region', 'product' => 'product'];
        $currentLang = \Session()->get('local');
        if ($this->categories_id)
            return $$currentLang['category'];
        /* elseif($this->products_id)
            return $$currentLang['product'];*/
        elseif ($this->regions_id)
            return $$currentLang['region'];
    }
}
