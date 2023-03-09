<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Statistical extends Model
{
    use HasFactory;

    protected $table = 'statisticals';
    protected $fillable = [
        'order_date',
        'price',
        'total_order'
    ];
}
