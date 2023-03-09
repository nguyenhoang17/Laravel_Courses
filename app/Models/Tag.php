<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
    ];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'tag_course', 'tag_id', 'course_id');
    }
    public function orders_detail()
    {
        return $this->belongsToMany(OrderDetail::class, 'tag_course', 'tag_id', 'course_id');
    }
}
