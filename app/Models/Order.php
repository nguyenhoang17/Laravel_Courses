<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'updated_by',
        'user_id',
        'course_id',
        'total',
        'type_payment',
        'status',
    ];
    const WAIT = 0;
    const CONFIRM= 1;
    const CANCEL = 2;
    public $statusArr = [
        self::WAIT => 'Chờ xác nhận',
        self::CONFIRM => 'Đã xác nhận',
        self::CANCEL => 'Đã hủy'
    ];


    const PAYMENT = [
        'TRANSFER' => 0,
        'VNPAY'   => 1
    ];

    const STATUS = [
        'WAIT' => 0,
        'SUCCESS' => 1,
        'CANCEL' => 2
    ];
    public function getStatusTextAttribute(){
        return $this->statusArr [$this->status];
    }

    public function setTotalAttribute($value){
        $this->attributes['total'] =  Crypt::encryptString($value);
    }

    public function getTotalAttribute($value){
        return (int)Crypt::decryptString($value);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class,'update_by')->withTrashed();
    }

    public function orders_detail()
    {
        return $this->hasMany(OrderDetail::class);
    }
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
