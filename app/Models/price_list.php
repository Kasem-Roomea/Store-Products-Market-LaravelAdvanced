<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class price_list extends Model
{
    protected $table = 'price_list';
    protected $fillable = [
        'startKm', 'endKm', 'price','minPrice' , 'maxPrice' , 'minPriceForOrder','createdAt'
    ];
    public $timestamps = false;
}
