<?php
namespace App\Http\Controllers\Apis\Controllers\makeOrder\wallet;
use App\Http\Controllers\Apis\Controllers\index;

class myCredit {
    
    private $account,$bill,$appInfo;
    public $responseError;
    
    function __construct($account,$bill,$appInfo)
    {
        $this->account= $account;
        $this->bill= $bill;
        $this->appInfo= $appInfo;
        $this->handle();
    }

    private function handle()
    {
        if($this->account->balance < $this->bill->totalPrice){
            $this->responseError= [
                "status"=>425,
                "yourBalance"=>$this->account->balance,
                "message"=>index::$messages['order']["425"]
            ];
        }else{

            $this->account->decrement('balance',$this->bill->totalPrice);

        }
    }
}
