<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Apis\Helper\helper;
use Carbon\Carbon;

class orders extends GeneralModel
{
  protected $table = 'orders',

    $appends = [
      "bill", "isDiscounted", 'statusAr', "deliveryPrice", "products_price", "totalPrice",
      "fees", "mapLink", 'driverFees', 'storeFees', 'online_payment_confirm_text', "online_payment_confirm", "paymentMethodAr"
    ],
    $with = ["reason", 'user', 'driver', 'store'];
  public $guarded=[];
  public static function createUpdate($params)
  {
    $record = isset($params["id"]) ? self::find($params["id"]) : new self();
    $record->code = isset($params["id"]) ? $record->code : helper::UniqueRandomXDigits(6, 'code', ['orders']);
    $record->status = isset($params["status"]) ? $params["status"] : $record->status;
    $record->users_id = isset($params["users_id"]) ? $params["users_id"] : $record->users_id;
    $record->stores_id = isset($params["stores_id"]) ? $params["stores_id"] : $record->stores_id;
    $record->extraDescription = isset($params["extraDescription"]) ? $params["extraDescription"] : $record->extraDescription;
    $record->purchase_address_id = isset($params["purchase_address_id"]) ? $params["purchase_address_id"] : $record->purchase_address_id;
    $record->deliveryTime = isset($params["deliveryTime"]) ? $params["deliveryTime"] : $record->deliveryTime;
    $record->drivers_id = isset($params["drivers_id"]) ? $params["drivers_id"] : $record->drivers_id;
    $record->delivery_address_id = isset($params["delivery_address_id"]) ? $params["delivery_address_id"] : $record->delivery_address_id;
    $record->paymentMethod = isset($params["paymentMethod"]) ? $params["paymentMethod"] : $record->paymentMethod;
    $record->freeDelivery = isset($params["freeDelivery"]) ? $params["freeDelivery"] : $record->freeDelivery;
    $record->reason_to_cancel_id = isset($params["reason_to_cancel_id"]) ? $params["reason_to_cancel_id"] : $record->reason_to_cancel_id;
    isset($params["id"]) ?: $record->createdAt = date("Y-m-d H:i:s");
    !isset($params["deletedAt"]) ?: $record->deletedAt = date("Y-m-d H:i:s");
    $record->save();
    return $record;
  }
  public function user()
  {
    return $this->belongsTo(users::class, "users_id");
  }
  public function driver()
  {
    return $this->belongsTo(drivers::class, "drivers_id");
  }
  public function reason()
  {
    return $this->belongsTo(reason_to_cancel::class, "reason_to_cancel_id");
  }
  // function GetDiscountCodeAttribute()
  // {
  //     $code= code_used::where("orders_id",$this->id)->first();
  //     return $code ? $code->code->discount :0;
  // }
  function GetIsDiscountedAttribute()
  {
    $code = code_used::where("orders_id", $this->id)->first();
    return $this->discountCode ? true : false;
  }
  function GetImagesAttribute()
  {
    return order_images::where("orders_id", $this->id)->pluck("image")->toArray();
  }
  function GetstatusArAttribute()
  {
    $statusAr = [
      'waiting' => "في الانتظار",
      "accept" => "تمت الموافقة",
      "progressing" => "جاري التنفيذ",
      "processing" => "الطلب في الطريق",
      'cancel' => "ملغي",
      'finished' => 'انتهي',
      "returned" => "تم الارجاع",
    ];
    return $statusAr[$this->status];
  }
  public function store()
  {
    //$cart = $this->carts->first() ?? null;
    //if ($cart) {
    //return $cart->product->category->store;
    //}

    // $store = stores::where("id", $this->stores_id);
    //  return $store;
    return $this->belongsTo(stores::class, "stores_id");
  }
  // function GetStoresIdAttribute()
  // {
  //     dd($this->attributes);
  //     if($this->attributes['stores_id'])
  //       return $this->attributes['stores_id'];

  //     $carts = $this->carts->first()??null;
  //     if($carts){
  //         return $carts->product->category->stores_id;
  //     }
  // }
  function GetBillAttribute()
  {
    $bill = bills::where("orders_id", $this->id)
      ->first();
    if (!$bill) {
      return null;
    } else {
      return $bill;
    }
  }
  function GetDeliveryPriceAttribute()
  {
    $bill = bills::where("orders_id", $this->id)
      ->first();
    if (!$bill) {
      return 0;
    } else {
      return $bill->deliveryPrice;
    }
  }
  function GetProductsPriceAttribute()
  {
    $bill = bills::where("orders_id", $this->id)
      ->first();
    if (!$bill) {
      return 0;
    } else {
      return $bill->products_price;
    }
  }
  function GetTotalPriceAttribute()
  {
    $bill = bills::where("orders_id", $this->id)
      ->first();
    if (!$bill) {
      return 0;
    } else {
      return $bill->totalPrice;
    }
  }
  function GetDriverFeesAttribute()
  {
    $bill = bills::where("orders_id", $this->id)
      ->first();
    if (!$bill) {
      return 0;
    } else {
      return $bill->driverFees;
    }
  }
  function GetStoreFeesAttribute()
  {
    $bill = bills::where("orders_id", $this->id)
      ->first();
    if (!$bill) {
      return 0;
    } else {
      return $bill->storeFees;
    }
  }
  function GetFeesAttribute()
  {
    $bill = bills::where("orders_id", $this->id)
      ->first();
    if (!$bill) {
      return 0;
    } else {
      return $bill->fees;
    }
  }
  function GetMapLinkAttribute()
  {
    // return $this->delivery_address;
    $latitude = $this->delivery_address->latitude ?? 0;
    $longitude = $this->delivery_address->longitude ?? 0;
    return "https://maps.google.com/?q={$latitude},{$longitude}";
  }
  function order_online_payments()
  {
    return $this->hasMany(order_online_payments::class, 'orders_id');
  }
  function GetOnlinePaymentConfirmTextAttribute()
  {
    $order_online_payments = order_online_payments::where("orders_id", $this->id)->first();

    if (!$order_online_payments) {
      return null;
    }
    return $order_online_payments->check ? "تم الدفع" : " لم يتم الدفع";
  }
  function GetOnlinePaymentConfirmAttribute()
  {
    $order_online_payments = order_online_payments::where("orders_id", $this->id)->first();

    if (!$order_online_payments) {
      return 1;
    }
    return $order_online_payments->check ? 1 : 0;
  }
  public function purchase_address()
  {
    return  $this->belongsTo(locations::class, 'purchase_address_id');
  }
  public function delivery_address()
  {
    return  $this->belongsTo(locations::class, 'delivery_address_id');
  }
  function getPaymentMethodArAttribute()
  {
    $arr = [
      "Ar" => [
        'cash' => "كاش",
        'visa' => "فيزا",
        'myCredit' => "رصيدي",
        'points' => "نقاط"
      ],
      "En" => [
        'cash' => "cash",
        'visa' => "visa",
        'myCredit' => "myCredit",
        'points' => "myCredit",
      ]
    ];
    return $arr[\Session()->get('local')][$this->paymentMethod] ?? null;
  }


    //العلاقة بين السائق والطلب
    public function nameDriverOrders()
    {
        return $this->belongsTo('App\Models\drivers', 'drivers_id', 'id');
    }

    //العلاقة بين المستخدم والطلب
    public function nameUserOrder()
    {
        return $this->belongsTo('App\Models\users', 'users_id', 'id');
    }

    //العلاقة بين المخزن والطلب
    public function nameStoreOrder()
    {
        return $this->belongsTo('App\Models\stores', 'stores_id', 'id');
    }

    public function carts()
    {
        return  $this->hasMany(carts::class, 'orders_id');
    }
}
