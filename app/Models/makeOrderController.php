<?php
namespace App\Http\Controllers\Apis\Controllers\makeOrder;

use App\Http\Controllers\Controller;
use App\Lib\thawani\thawaniPay;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Resources\objects;
use App\Http\Controllers\Apis\Controllers\index;
use App\Models\orders;
use App\Models\bills;
use App\Models\products;
use App\Models\prices;
use App\Models\carts;
use App\Models\stores;
use App\Models\appInfo;
use App\Models\online_payment_confirm;
use App\Models\order_online_payments;
use App\Models\locations;
use App\Models\price_list;
use App\Models\features_in_carts;
use App\Models\features;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\URL;
use phpseclib\Crypt\RSA;
use App\Http\Controllers\Apis\Controllers\makeOrder\wallet\factoryWallet;
use App\Services\makeOrderService;

class makeOrderController extends index
{
    public static function api() 
    {
        $message = [];
        $appInfo = appInfo::first();
        $carts= carts::where('users_id',self::$account->id)->where('orders_id',null)->get();
        if($carts->count()==0) return ['message'=>'your cart is empty.'];
        $products= products::find($carts->pluck('products_id'));
        $store = $products->first()->store;
        $store = stores::first();
        $storeLocation= $store->location;
        $check_delivery_price = $products->sum("isFreeDelivered")/$products->count();
        $distance= self::checkForDistance($storeLocation); 
        $deliveryPrice=0;
        
        if($check_delivery_price != 1){
            $price_list = price_list::where('startKm','<=',$distance)->where('endKm','>=',$distance)->first();
            if(!$price_list)
                return [
                    'status'=>417,
                    'message'=>'location is out of Range, the distance between you and store is '.round($distance,2).' Km',
                    'maxRange'=>price_list::max('endKm')
                ];
            $deliveryPrice = $price_list->price;
        }

        $location = locations::createUpdate([
            "latitude"=>self::$request->orderLocation['latitude'],
            "longitude"=>self::$request->orderLocation['longitude'],
            "address"=>self::$request->orderLocation['address'],
        ]);

        // calculate product price 
        $products_price=$carts->sum(function($cart){
            return $cart['price']*$cart['quantity'];
        });
        
        if($products_price < 3 ){
            return [
                "status"=>430, 
                "message"=>self::$messages['order']["435"]
            ];
        }
        
        $order = orders::createUpdate([
            "status"=>"waiting",
            "extraDescription"=>self::$request->extraDescription,
            "deliveryTime"=>self::$request->deliveryTime,
            "paymentMethod"=>self::$request->paymentMethod,
            "users_id"=>self::$account->id,
            "extraDescription"=>self::$request->extraDescription,
            "delivery_address_id"=>$location->id
        ]);
       
        // save order id 
        carts::whereIn('id',$carts->pluck('id'))->update(['orders_id'=>$order->id]);
        
        $discounted=null;
        if(self::$request->discountCode){
            if($store->discountCode == self::$request->discountCode && $store->has_offer){
                $discounted=$store->discount/100*($products_price);
                $products_price=$products_price- $store->discount/100*($products_price)   ;
            }
        } 
    
        // return [round($delivery_price,2),$delivery_price];
        // $fees =  $store->fees??$appInfo->storeFees;
        $fees =  $appInfo->storeFees;
        $storeFees = ($products_price/100 * $fees) ;

        if(self::$request->paymentMethod=='Cash'){
            $storeFees += $appInfo->cashFees;
        }
        $bill = bills::create([
            "orders_id"     =>$order->id,
            "deliveryPrice" =>$deliveryPrice,
            "products_price"=>$products_price,
            "totalPrice"    =>$deliveryPrice +  $products_price + $storeFees,
            "storeFees"   =>$storeFees,
            "discounted" =>$discounted,
            'createdAt'=>now()
        ]);
        self::$account->save();

        $wallet= new factoryWallet(self::$account,$appInfo,$bill,self::$request->paymentMethod);
        if($wallet->wallet->responseError){
            $bill->delete();
            carts::where('orders_id',$order->id)->update(['orders_id'=>null]);
            $order->delete();
            return $wallet->wallet->responseError;
        }

        makeOrderService::incrementPoints($carts,self::$account,$appInfo);
        
        $stores= stores::where('isActive',1)->where('isVerified',1)->get();
        helper::newNotify($stores, self::$messagesAll["Ar"]["order"]["store"], self::$messagesAll["En"]["order"]["store"], $order->id , null,null, self::$messagesAll["Ar"]["order"]["titleMakeOrder"], self::$messagesAll["En"]["order"]["titleMakeOrder"]);
        foreach($stores as $store)
            helper::SocketStore($store->id,'makeOrder',objects::order($order));
        
        return [
            "status"=>200,
            "order"=>objects::order($order),
            "message"=>self::$messages['order']["waiting"]
        ];
    }

    static function checkForDistance($storeLocation)
    {
        return 
            helper::distance(
                $storeLocation->latitude,
                $storeLocation->longitude,
                request()->orderLocation['latitude'],
                request()->orderLocation['longitude'],
            );
    }
}
