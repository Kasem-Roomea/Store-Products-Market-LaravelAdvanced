<?php
namespace App\Http\Controllers\Apis\Controllers\makeOrder\wallet;

use App\Models\users;
class factoryWallet {
    public $wallet;
    function __construct($account,$bill,$appInfo,$type)
    {
        switch($type){
            case  'visa':
                $this->wallet = new visa($account,$appInfo,$bill);
            break;
            case  'points':
                $this->wallet = new points($account,$appInfo,$bill);
            break;
            case  'cashback':
                $this->wallet = new cashback($account,$appInfo,$bill);
            break;
            case  'Cash':
                $this->wallet = new cash($account,$appInfo,$bill);
            break;
            case  'myCredit':
                $this->wallet = new myCredit($account,$appInfo,$bill);
            break;
        }
    }
}
