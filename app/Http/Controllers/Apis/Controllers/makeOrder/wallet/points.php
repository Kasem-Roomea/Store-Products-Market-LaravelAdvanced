<?php
namespace App\Http\Controllers\Apis\Controllers\makeOrder\wallet;
use App\Http\Controllers\Apis\Controllers\index;

class points {
   public $responseError;
   private $account,$bill,$appInfo;

    function __construct($account,$bill,$appInfo)
    {
        $this->account= $account;
        $this->bill= $bill;
        $this->appInfo= $appInfo;
        $this->handle();
    }

    private function handle()
    {
        $points = $this->account->points;
        if($points < $this->appInfo->maxStorePoints){
            return $this->responseError= [
                "status"=>426,
                "yourPoints"=>$this->account->points,
                "MinimumPointsToReplace"=>$this->appInfo->maxStorePoints,
                "message"=>index::$messages['order']["426"]
            ];
        }
        $pointsToBalance= $points*$this->appInfo->priceOfPoint;
        if($pointsToBalance < $this->bill->totalPrice){
            return $this->responseError= [
                "status"=>427,
                "yourPointsToBalance"=>$pointsToBalance,
                "message"=>index::$messages['order']["427"]
            ];
        }
        $pointNeed = $this->bill->totalPrice/$this->appInfo->priceOfPoint ;
        $this->account->decrement('points',$pointNeed);
    }
}
