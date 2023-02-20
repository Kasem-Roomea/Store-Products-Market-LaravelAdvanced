<?php
namespace App\Http\Controllers\Apis\Resources;

use App\Models\users;

class walletResource
{
    private $user;
    public string $points;
    public string $cashback;
    public string $balance;

    function __construct(users $user){

        $this->user= $user;
        $this->handle();
    }

    
    public function handle()
    {
        $this->points = $this->user->points     . __('lang.point');
        $this->cashback = $this->user->cashback . __('lang.AED');
        $this->balance = $this->user->balance   . __('lang.AED');
    }

    
}