<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $table = 'order_detail';
    protected $fillable = [
        'order_id',
        'name',
        'category_id',
        'staff_id',
        'image',
        'video',
        'type',
        'file',
        'start_time',
        'end_time',
        'description',
        'is_featured',
        'publiced_at',
        'price',
        'is_live'
    ];

    const TYPE_ONDEMAND = 1;
    const TYPE_LIVE = 2;

    const STATUS = [
        'WAITING_LIVE'=> 0,
        'LIVING'       => 1,
        'LIVED'       => 2,
    ];

    protected  $typeViewArr = [
        self::TYPE_ONDEMAND => 'Video',
        self::TYPE_LIVE => 'Skype'
    ];

    public function getTypeViewAttribute(){
        return $this->typeViewArr [$this->type];
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tag_course', 'course_id', 'tag_id');
    }
    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
