<?php

namespace App\Http\Controllers\Apis\Resources;

use App\Http\Controllers\Apis\Helper\helper;
use  App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Controller;
use App\Models\phones;
use App\Models\emails;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\appInfo;
use App\Models\favorites;

class objects extends index
{
    public static function account($record)
    {
        if ($record == null) {
            return null;
        }
        $object = [];
        $object['apiToken'] = $record->apiToken;
        $object['name'] = $record->name;
        $object['phone'] = Str::replaceFirst('00', '+', $record->phone);
        $object['email'] = $record->email;
        $object['socialToken'] = $record->social_token;
        $object['type'] = Str::singular($record->getTable());
        $object[Str::singular($record->getTable())] = self::{Str::singular($record->getTable())}($record);
        return $object;
    }

    public static function user($record)
    {
        if ($record == null) {
            return null;
        }
        $object = [];
        $object['id'] = $record->id;
        $object['name'] = $record->name;
        $object['phone'] = Str::replaceFirst('00', '+', $record->phone);
        $record->image == null ?: $object['image'] = request()->root() . $record->image;
        $record->fees == null ?: $object['fees'] = $record->fees;
        $object['rate'] = $record->rate;
        return $object;
    }

    public static function driver($record)
    {
        if ($record == null) {
            return null;
        }
        $object = [];
        $object['id'] = $record->id;
        $record->image == null ?: $object['image'] = request()->root() . $record->image;
        $object['deliveryMethod'] = self::deliveryMethod($record->delivery_method);
        $record->model == null ?: $object['model'] = $record->model;
        $record->licenseNumber == null ?: $object['licenseNumber'] = $record->licenseNumber;
        $record->driverLicenseImage == null ?: $object['driverLicenseImage'] = request()->root() . $record->driverLicenseImage;
        $record->carLicenseImage == null ?: $object['carLicenseImage'] = request()->root() . $record->carLicenseImage;
        $record->IdPhoto == null ?: $object['IdPhoto'] = request()->root() . $record->IdPhoto;
        $record->carImage == null ?: $object['carImage'] = request()->root() . $record->carImage;
        $record->fees == null ?: $object['fees'] = $record->fees;
        $object['rate'] = $record->rate;
        return $object;
    }

    public static function driverInOrder($record)
    {
        if ($record == null) {
            return null;
        }
        $object = [];
        $object['id'] = $record->id;
        $record->image == null ?: $object['image'] = request()->root() . $record->image;
        $object['name'] = $record->name;
        $object['phone'] = Str::replaceFirst('00', '+', $record->phone);
        $object['email'] = $record->email;
        $object['rate'] = $record->rate;
        return $object;
    }

    public static function deliveryMethod($record)
    {
        if ($record == null) {
            return null;
        }
        $object = [];
        $object['id'] = $record->id;
        $object['name'] = $record['name' . self::$lang];
        return $object;
    }

    public static function ad($record)
    {
        if ($record == null) {
            return null;
        }
        $object = [];
        $object['id'] = $record->id;
        $object['title'] = $record['title' . self::$lang];
        $object['screen'] = $record->screen;
        $record->category == null ?: $object['screen-category'] = self::category($record->category);
        $record->store == null ?: $object['screen-store'] = self::store($record->store);
        $object['action'] = $record->action;
        $record->actionProduct == null ?: $object['action-product'] = self::product($record->actionProduct);
        $record->actionStore == null ?: $object['action-store'] = self::store($record->actionStore);
        $record->actionCategory == null ?: $object['action-category'] = self::category($record->actionCategory);
        $record->link == null ?: $object['action-link'] = $record->link;
        $record->video == null ?: $object['video'] = request()->root() . $record->video;
        $record->image == null ?: $object['image'] = request()->root() . $record->image;
        return $object;
    }

    public static function notification($record)
    {
        // this object take record from notify table ;
        if ($record == null) {
            return null;
        }
        $object['id'] = $record->id;
        $object['title'] = $record->notification['title' . self::$lang];
        $object['content'] = $record->notification['content' . self::$lang];
        $record->order ? $object['order'] = self::order($record->order) : false;
        $record->offer ? $object['offer'] = self::offer($record->offer) : false;
        $record->product ? $object['product'] = self::order($record->product) : false;
        $object['isSeen'] = $record->is_seen == 1 ? true : false;
        $object['createdAt'] = Carbon::parse($record->createdAt)->timestamp;
        return $object;
    }

    public static function location($record)
    {
        if ($record == null) {
            return null;
        }
        $object = [];
        $object['id'] = $record->id;
        $object['longitude'] = (float)$record->longitude;
        $object['latitude'] = (float)$record->latitude;
        $object['address'] = $record->address;
        $object['description'] = $record->description;
        $object['isDefult'] = (int)$record->isDefult;
        $object['createdAt'] = date("Y-m-d H:i:s", strtotime($record->createdAt));
        $object['createdAtInt'] = strtotime($record->createdAt);

        return $object;
    }

    public static function vehicle($record)
    {
        if ($record == null) {
            return null;
        }
        $object = [];
        $object['id'] = $record->id;
        $object['name'] = $record['name' . self::$lang];
        $record->image == null ?: $object['image'] = request()->root() . $record->image;
        return $object;
    }

    public static function faq($record)
    {
        if ($record == null) {
            return null;
        }
        $object = [];
        $object['id'] = $record->id;
        $object['question'] = $record['question' . self::$lang];
        $object['answer'] = $record['answer' . self::$lang];
        return $object;
    }

    public static function order($record)
    {
        if ($record == null) {
            return null;
        }
        $object = [];
        $object['id'] = $record->id;
        $record->delivery_address ? $object['orderLocation'] = self::location($record->delivery_address) : null;
        $object['createdAt'] = Carbon::parse($record->createdAt)->timestamp;
        $object['status'] = $record->status;
        $object['code'] = (string)$record->code;
        $object['user'] = self::user($record->user);
        $object['users_id'] = $record->users_id;
        $record->driver ? $object['driver'] = self::driverInOrder($record->driver) : null;
        $record->extraDescription ? $object['extraDescription'] = $record->extraDescription : null;
        $object['store'] = self::store($record->store);
        $object['carts'] = self::ArrayOfObjects($record->carts, 'cart');
        $object['deliveryTime'] = $record->deliveryTime;
        $object['paymentMethod'] = $record->paymentMethod;
        // $object['deliveryPrice'] = $record->deliveryPrice;        
        // $object['totalPrice'] = $record->totalPrice;
        $object['bill'] = self::bill($record->bill);
        $object['freeDelivery'] = $record->freeDelivery ? true : false;
        $object['pushAfter3Day'] = $record->pushAfter3Day ? true : false;
        $record->discountCode ? $object['discountCode'] = (string)$record->discountCode : null;
        return $object;
    }

    public static function cart($record)
    {
        if ($record == null) {
            return null;
        }
        $object = [];
        $object['id'] = $record->id;
        $object['product'] = self::product($record->product);
        $object['productId'] = $record->product->id;
        $object['quantity'] = $record->quantity;
        $object['totalQuantity'] = $record->total_quantity;
        $object['description'] = $record->description;
        $object['price'] = $record->price;
        $record->features ? $object['features'] = self::ArrayOfObjects($record->features, 'feature') : null;
        return $object;
    }

    public static function store($record)
    {
        if ($record == null) {
            return null;
        }
        $object = [];
        $object['id'] = $record->id;
        $object['name'] = $record->name;
        $record->location ? $object['location'] = self::location($record->location) : null;
        $object['category'] = self::category($record->category);
        $record->image == null ?: $object['image'] = request()->root() . $record->image;
        $object['rate'] = $record->rate;
        $record->deliveryTime ? $object['deliveryTime'] = $record->deliveryTime : null;
        $object['fees'] = $record->fees;
        $object['rate'] = $record->rate;
        return $object;
    }

    public static function category($record)
    {
        if ($record == null) {
            return null;
        }
        $object = [];
        $object['id'] = $record->id;
        $object['type'] = $record->categories_id ? 'subCategory' : 'mainCategory';
        $object['name'] = $record['name' . self::$lang];
        $record->image == null ?: $object['image'] = request()->root() . $record->image;
        return $object;
    }

    public static function product($record)
    {
        if ($record == null) {
            return null;
        }
        $object = [];
        $object['id'] = $record->id;
        $object['barcode'] = $record->ID_;
        $object['name'] =  $record['name' . self::$lang];
        $object['description'] =  $record['description' . self::$lang];
        $record->ratting == null ?: $object['rate'] =  $record->ratting;
        $object['price'] = $record->price;
        $object['isFreeDelivered'] = $record->isFreeDelivered ? true : false;
        $record->allImages == null ?: $object['images'] = $record->allImages;
        $record->lastoffer ? $object['offer'] = self::location($record->location) : null;
        $object['category'] = self::category($record->category);
        $record->category ? $object['store'] = self::store($record->category->store) : null;
        $object['quantity'] = $record->quantity;
        $object['hasWholesale'] = $record->prices->count() > 0 ? true : false;
        $object['brand'] = $record->brand;
        $record->brand ? $object['brand'] = self::brand($record->brand) : null;
        $record->offers ? $object['offers'] = self::ArrayOfObjects($record->offers, 'offer') : null;
        $record->prices ? $object['prices'] = self::ArrayOfObjects($record->prices, 'price') : null;

        if (self::$account)
            $object['isFav'] = favorites::where("users_id", self::$account->id)->where("products_id", $record->id)->count() ? true : false;
        else
            $object['isFav'] = false;
        $object['isFreeDelivered'] =  $record->isFreeDelivered ? true : false;
        $object['offers'] != null ? $object['hasOffer'] = self::hasOffer($object['offers']) : null;
        //$record->hasOffer ? $object['offer'] = self::offer($record) : null;
        // $record->points ? $object['points'] = self::points($record->points->first()):null;
        $object['point'] = (int)$record->points;
        $record->features ? $object['features'] = self::ArrayOfObjects($record->features, 'feature') : null;
        $object['viewers'] = $record->viewers ?? 0;
        return $object;
    }

    public static function hasOffer($offers)
    {
        foreach ($offers as $offer) {
            //error_log($offer);
            if ($offer['startAt'] <= date("Y-m-d") && $offer['endAt'] > date("Y-m-d")) {
                return true;
            }
        }
        return false;
    }

    public static function price($record)
    {
        if ($record == null) {
            return null;
        }
        $object = [];
        $object['id'] = $record->id;
        $object['price'] = $record['price'];
        $object['name'] = $record['name' . self::$lang];
        $object['quantity'] = $record['quantity'];
        $record->image == null ?: $object['image'] = request()->root() . $record->image;
        return $object;
    }

    public static function feature($record)
    {
        if ($record == null) {
            return null;
        }
        $object = [];
        $object['id'] = $record->id;
        $object['name'] = $record['name' . self::$lang];
        $object['price'] = $record['price'];
        $record->image == null ?: $object['image'] = request()->root() . $record->image;
        return $object;
    }

    public static function brand($record)
    {
        if ($record == null) {
            return null;
        }
        $object = [];
        $object['id'] = $record->id;
        $object['name'] = $record['name' . self::$lang];
        $record->image == null ?: $object['image'] = request()->root() . $record->image;
        return $object;
    }

    public static function offer($record)
    {
        if ($record == null || $record->isActive != 1) {
            return null;
        }
        $object = [];
        $object['id'] = $record->id;
        // $object['product'] = self::product($record->product);
        $object['discount'] = (float)$record->discount;
        $object['discountStr'] = $record->discount . '%';
        $object['startAt'] = $record->startAt;
        $object['endAt'] = $record->endAt;
        $object['productId'] = $record->products_id;

        //  $object['price'] = $record->product->price - ($record->product->price / 100 * $record->discount);
        return $object;
    }

    public static function points($record)
    {
        if ($record == null) {
            return null;
        }
        $object = [];
        $object['id'] = $record->id;
        $record->image == null ?: $object['image'] = request()->root() . $record->image;
        $object['numberOfPoints'] = $record->numberOfPoints;
        $object['description'] =  $record['description' . self::$lang];
        return $object;
    }

    public static function bill($record)
    {
        if ($record == null) {
            return null;
        }
        $object = [];
        $object['deliveryPrice'] = $record->deliveryPrice;
        $object['productsPrice'] = $record->products_price;
        $object['fees'] =  $record->storeFees;
        $object['discounted'] =  $record->discounted;
        $object['totalPrice'] =  $record->totalPrice;
        // $object['discounted'] =  $record->discounted;

        return $object;
    }

    public static function appInfo($record)
    {

        if ($record == null) {
            return null;
        }
        $object = [];
        $object['email']   = $record->emails->pluck('email')->toArray();
        $object['phones']   = $record->phones->pluck('phone')->toArray();
        $object['welcome'] = $record['welcome' . self::$lang];
        $object['about'] = $record['about' . self::$lang];
        $object['policy'] = $record['policy' . self::$lang];
        $object['privacy'] = $record['privacy' . self::$lang];
        $object['registerPoints'] = $record->registerPoints;
        $object['firstOrderPoints'] = $record->firstOrderPoints;
        $object['pricePerKM'] = $record->pricePerKM;
        $object['cashFees'] = $record->cashFees;

        $object['feesOfCancellation'] = $record->feesOfCancellation;
        $object['pricePer20Km'] = (float)$record->pricePer20Km;
        return $object;
    }

    public static function ArrayOfObjects($Items, $objectname)
    {

        if (count($Items) == 0) return $Items;

        $Array = [];
        foreach ($Items as $Item) {
            $Array[] = self::$objectname($Item);
        }
        $final_Array = [];

        foreach ($Array as $A)
            if ($A == null)
                continue;
            else
                array_push($final_Array, $A);
        return $final_Array;
    }
}
