<?php
namespace App\Http\Controllers\Apis\Controllers\makeOrder\wallet;

use App\Models\order_online_payments;

class visa {

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
        order_online_payments::create([
            'orders_id'=>$this->bill->orders_id,
            'PaymentId'=>request()->PaymentId,
            'created_at'=>now()
        ]);
    }
}


    
