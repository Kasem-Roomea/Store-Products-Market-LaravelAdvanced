<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order_online_payments extends Model
{
    use HasFactory;
    public $timestamps=false,$guarded=[];
    
    public function order(){
        return $this->belongsTo(orders::class,"orders_id");
    }

}
