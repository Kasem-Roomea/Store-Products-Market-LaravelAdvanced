<?php
namespace App\Http\Controllers\Apis\Controllers\makeOrder\wallet;

class cash {
    private $account,$bill,$appInfo;
    public $responseError;

    function __construct($account,$bill,$appInfo)
    {
        $this->account= $account;
        $this->bill= $bill;
        $this->appInfo= $appInfo;
    }
}
