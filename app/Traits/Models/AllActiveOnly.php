<?php 
namespace App\Traits\Models;

trait AllActiveOnly {

    public function scopeAllActiveOnly($query)
    {
        return $query->where('isActive',1)->get();
    }
}