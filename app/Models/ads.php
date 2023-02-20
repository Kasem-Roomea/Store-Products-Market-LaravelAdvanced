<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Apis\Helper\helper ;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ads extends Model
{
    protected $table = 'ads', $appends=['screenAr',"itemScreen","actionAr","itemAction"];
    protected $guarded = [];
    public $timestamps = false;


    //العلاقة بين الاقسام وعرض الاعلانات
    public function nameCategoriesAds()
    {
        return $this->belongsTo('App\Models\categories','categories_id' , 'id');
    }

    //العلاقة بين المخازن وعرض الاعلانات
    public function nameStoresAds()
    {
        return $this->belongsTo('App\Models\stores','stores_id' , 'id');
    }

    //العلاقة بين الاقسام الفرعية وطريقة توجيه الاعلان
    public function nameCategoriesActionAds()
    {
        return $this->belongsTo('App\Models\categories','action_categories_id' , 'id');
    }

    //العلاقة بين المتجر وطريقة توجيه الاعلان
    public function nameStoresActionAds()
    {
        return $this->belongsTo('App\Models\stores','action_stores_id' , 'id');
    }

    //العلاقة بين المنتجات وطريقة توجيه الاعلان
    public function nameProductActionAds()
    {
        return $this->belongsTo('App\Models\products','action_products_id' , 'id');
    }

    public static function createUpdate($params){

        $record= isset($params["id"])? self::find($params["id"]) :new self();
        $record->titleAr = isset($params["titleAr"])? $params["titleAr"]: $record->titleAr;
        $record->titleEn = isset($params["titleEn"])? $params["titleEn"]: $record->titleEn;
        $record->startAt = isset($params["startAt"])? $params["startAt"]: $record->startAt;
        $record->endAt = isset($params["endAt"])? $params["endAt"]: $record->endAt;
        $record->screen = isset($params["screen"])? $params["screen"]: $record->screen;
        $record->link = isset($params["link"])? $params["link"]: $record->link;
        $record->products_id = isset($params["products_id"])? $params["products_id"]: $record->products_id;
        $record->offers_id = isset($params["offers_id"])? $params["offers_id"]: $record->offers_id;
        $record->categories_id = isset($params["categories_id"])? $params["categories_id"]: $record->categories_id;
        $record->stores_id = isset($params["stores_id"])? $params["stores_id"]: $record->stores_id;
        $record->action = isset($params["action"])? $params["action"]: $record->action;
        $record->action_stores_id = isset($params["action_stores_id"])? $params["action_stores_id"]: $record->action_stores_id;
        $record->action_products_id = isset($params["action_products_id"])? $params["action_products_id"]: $record->action_products_id;
        $record->action_categories_id = isset($params["action_categories_id"])? $params["action_categories_id"]: $record->action_categories_id;
        $record->image =isset($params['image'])?helper::base64_image_dash( $params['image'],'users'): $record->image;
        $record->video =isset($params['video'])?helper::uploadPhoto( $params['video'],'ads'): $record->video;
        $record->deletedAt = isset($params["deletedAt"])? date("Y-m-d H:i:s"):null;
        isset($params["id"])?:$record->createdAt = date("Y-m-d H:i:s");
        $record->save();
        return $record;
    }
    public function product()
    {
        return $this->belongsTo(products::class, 'products_id');
    }
    public function store()
    {
        return $this->belongsTo(stores::class, 'stores_id');
    }
    public function category()
    {
        return $this->belongsTo(categories::class, 'categories_id');
    }
    public function actionProduct()
    {
        return $this->belongsTo(products::class, 'action_products_id');
    }
    public function actionStore()
    {
        return $this->belongsTo(stores::class, 'action_stores_id');
    }
    public function actionCategory()
    {
        return $this->belongsTo(categories::class, 'action_categories_id');
    }
    public function offer()
    {
        return $this->belongsTo(offers::class, 'offers_id');
    }
    function GetScreenArAttribute()
    {
        $screen=[
            "Ar"=>[
                "welcome"=>"الشاشة الرئيسية",
                "offer"=>"شاشة العروض",
                "categories"=>"شاشة الاقسام",
                "stores"  =>"شاشة المتاجر"
            ],"En"=>[
                "welcome"=>"main screen",
                "offer"=>"screen offers",
                "categories"=>"Home screen",
                "stores"  =>"store screen"

            ]
        ];
        return $screen[\Session()->get('local')][$this->screen];
    }
    function GetItemScreenAttribute()
    {
        if($this->categories_id){
            return $this->category->nameAr;
        }
        if($this->stores_id){
            return $this->store->name;
        }
        else 
            return null;
    }
    function GetActionArAttribute()
    {
        $action=[
            "Ar"=>[
                "link"=>"مصدر خارجي ",
                "products"=>"شاشة منتج",
                "categories"=>"شاشة قسم فرعي",
                "stores"  =>"شاشة متجر"
            ],"En"=>[
                "link"=>"external source ",
                "products"=>"product screen",
                "categories"=>"sub category screen" ,
                "stores"  =>"store screen"
            ]
        ];
        return $action[\Session()->get('local')??'Ar'][$this->action];
    }
    function GetItemActionAttribute()
    {
        if($this->action_categories_id){
            return $this->actionCategory->nameAr;
        }
        if($this->action_stores_id){
            return $this->actionStore->name;
        }
        if($this->action_products_id){
            return $this->actionProduct->nameAr;
        }
        else 
            return $this->link;
    }
}
