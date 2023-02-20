<?php
namespace App\Http\Controllers\Apis\Controllers\makeOrder\wallet;
use App\Http\Controllers\Apis\Controllers\index;

class cashback {
    private $account,$bill,$appInfo;
    function __construct($account,$bill,$appInfo)
    {
        $this->account= $account;
        $this->bill= $bill;
        $this->appInfo= $appInfo;
    }
}
