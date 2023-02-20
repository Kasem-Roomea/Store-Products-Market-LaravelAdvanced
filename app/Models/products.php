<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class products extends Model
{
    use \App\Traits\Models\AllActiveOnly;

    protected $table = 'products', $with = ["offers", "prices", "images", "features", 'category', 'brand', 'section'], $appends = [
            'store', 'storeName',
            'storeEmail', 'storePhone', 'ratting', 'hasOffer', 'hasOfferAr', 'hasOfferLast', 'allImages', 'finalPrice'
        ];
    public $timestamps = false, $guarded = [];

    public static function createUpdate($params)
    {

        $record = isset($params["id"]) ? self::find($params["id"]) : new self();
        $record->ID_ = isset($params["ID_"]) ? $params["ID_"] : $record->ID_;
        $record->nameAr = isset($params["nameAr"]) ? $params["nameAr"] : $record->nameAr;
        $record->nameEn = isset($params["nameEn"]) ? $params["nameEn"] : $record->nameEn;
        $record->descriptionAr = isset($params["descriptionAr"]) ? $params["descriptionAr"] : $record->descriptionAr;
        $record->descriptionEn = isset($params["descriptionEn"]) ? $params["descriptionEn"] : $record->descriptionEn;
        $record->price = isset($params["price"]) ? $params["price"] : $record->price;
        $record->product_price = isset($params["product_price"]) ? $params["product_price"] : $record->product_price;
        $record->viewers = isset($params["viewers"]) ? $params["viewers"] : $record->viewers;
        $record->quantity = isset($params["quantity"]) ? $params["quantity"] : $record->quantity;
        $record->points = isset($params["points"]) ? $params["points"] : $record->points;
        $record->isFreeDelivered = isset($params["isFreeDelivered"]) ? $params["isFreeDelivered"] : $record->isFreeDelivered;
        $record->start_at_offer = isset($params["start_at_offer"]) ? $params["start_at_offer"] : $record->start_at_offer;
        $record->end_at_offer = isset($params["end_at_offer"]) ? $params["end_at_offer"] : $record->end_at_offer;
        $record->discount = isset($params["discount"]) ? $params["discount"] : $record->discount;
        $record->categories_id  = isset($params["categories_id"]) ? $params["categories_id"] : $record->categories_id;
        $record->deletedAt = isset($params["deletedAt"]) ? date("Y-m-d H:i:s") : null;
        isset($params["id"]) ?: $record->createdAt = date("Y-m-d H:i:s");
        $record->save();
        return $record;
    }

    //العلاقة بين المخازن وعرض المنتجات
    public function nameStoresProduct()
    {
        return $this->belongsTo('App\Models\stores','stores_id' , 'id');
    }

    //العلاقة بين الاقسام والمنتجات
    public function nameCategoriesProduct()
    {
        return $this->belongsTo('App\Models\categories','categories_id' , 'id');
    }


    public function images()
    {
        return $this->hasMany(images::class, 'products_id');
    }

    public function offers()
    {
        return $this->hasMany(offers::class, 'products_id');
    }

    public function features()
    {
        return $this->hasMany(features::class, 'products_id');
    }
    public function prices()
    {
        return $this->hasMany(prices::class, 'products_id');
    }
    public function category()
    {
        return $this->belongsTo(categories::class, 'categories_id');
    }
    public function brand()
    {
        return $this->belongsTo(brands::class, 'brands_id');
    }
    public function section()
    {
        return $this->belongsTo(sections::class, 'sections_id');
    }

    public function reviews()
    {
        return $this->hasMany(reviews::class, 'products_id');
    }
    function GetRattingAttribute()
    {
        return (float) ($this->reviews ? $this->reviews->avg('rate') : 0);
    }

    function GetStoreNameAttribute()
    {
        // return $this->category->store->name??'';
    }

    function GetStorePhoneAttribute()
    {
        // return $this->category->store->phone??'';
    }

    function GetStoreEmailAttribute()
    {
        // return $this->category->store->email??'';
    }

    function GetStoreAttribute()
    {
        // return $this->category->store??'';
    }

    function GetAllImagesAttribute()
    {
        $images =  $this->images;
        $arr = [];
        foreach ($images as $image) {
            $arr[] = request()->root() . $image->image;
        }
        return $arr;
    }



    function GetHasOfferAttribute()
    {
        if ($this->discount) {
            if ($this->start_at_offer <= date("Y-m-d") && $this->end_at_offer > date("Y-m-d"))
                return true;
        }
        return false;
    }
    function GetHasOfferArAttribute()
    {
        if ($this->discount) {
            if ($this->start_at_offer <= date("Y-m-d") && $this->end_at_offer > date("Y-m-d"))
                return 'نعم';
        }
        return 'لا';
    }
    function GetFinalPriceAttribute()
    {
        if ($this->discount) {
            if ($this->start_at_offer < date("Y-m-d") && $this->end_at_offer > date("Y-m-d"))
                return $discount = $this->price - $this->price * $this->discount / 100;
        }
        return $this->price;
    }

    function GetHasOfferLastAttribute()
    {
        if ($this->start_at_offer ||   $this->end_at_offer)
            return 'نعم';
        return 'لا';
    }
}
