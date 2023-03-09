<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    const DEFAULT = 0;
    const PUBLIC_COURSES= 1;
    public $statusArr = [
        self::DEFAULT => 'Mặc Định',
        self::PUBLIC_COURSES => 'Đã Thêm Vào Khóa Học'
     ];
    protected $table = 'categories';
    protected $fillable = [
        'name',
        'image',
        'description',
        'status'
    ];
    public function getStatusTextAttribute(){
        return $this->statusArr [$this->status];
    }
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
    public function getImageUrlAttribute(){
        return url(\Illuminate\Support\Facades\Storage::url($this->image));
    }

}
