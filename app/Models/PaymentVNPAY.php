<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentVNPAY extends Model
{
    use HasFactory;
    protected $table = 'payment_vnpay';

    protected $fillable = [
        'user_id',
        'order_id',
        'code',
        'money',
        'content',
        'status',
        'code_bank',
        'time'
    ];

    const STATUS = [
        'UNPAID'        => 0,
        'SUCCESS'       => 1,
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class,'order_id');
    }
}
