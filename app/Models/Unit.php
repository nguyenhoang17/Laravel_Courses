<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;
    protected $table = 'units';

    protected $fillable = [
        'name',
        'course_id',
        'video',
        'file',
        'index',
    ];
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

}
