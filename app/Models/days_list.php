<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class days_list extends Model
{
    use HasFactory;
    protected $table = 'days_list';
    public $guarded=[],$timestamps=false;
}
