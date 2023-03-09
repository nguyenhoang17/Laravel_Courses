<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $table = 'courses';
    const PRIVATE  = 0;
    const PUBLIC_COURSES= 1;
    const HIGHLIGHT = 2;

    public $statusArr = [
        self::PRIVATE => 'Không công khai',
        self::PUBLIC_COURSES => 'Công khai',
        self::HIGHLIGHT => 'Nổi bật'
     ];

    protected $fillable = [
        'name',
        'category_id',
        'staff_id',
        'image',
        'video',
        'type',
        'file',
        'key',
        'start_time',
        'end_time',
        'description',
        'status',
        'is_featured',
        'publiced_at',
        'price'
    ];

    const STATUS_PUBLISHED = 1;
    const STATUS_UNPUBLISHED = 0;

    const TYPE_ONDEMAND = 1;
    const TYPE_LIVE = 2;

    const FEATURED = 1;
    const NO_FEATURED = 0;

    const START_LIVE = 1;
    const UN_START_LIVE = 0;

    static $typeCourses = [
        self::TYPE_ONDEMAND => '1',
        self::TYPE_LIVE => '2'
        ];
    protected  $typeTextArr = [
        self::TYPE_ONDEMAND => 'Khoá học xem video',
        self::TYPE_LIVE => 'Khoá học qua skype'
    ];

    protected  $typeViewArr = [
        self::TYPE_ONDEMAND => 'Video',
        self::TYPE_LIVE => 'Skype'
    ];

    protected  $statusTextArr = [
        self::STATUS_PUBLISHED => 'Đươc phát hành',
        self::STATUS_UNPUBLISHED => 'Chưa phát hành',
    ];

    protected  $featuredTextArr = [
        self::FEATURED => 'Nổi bật',
        self::NO_FEATURED => 'Chưa nổi bật',
    ];

    public function getTypeTextAttribute(){
        return $this->typeTextArr [$this->type];
    }

    public function getTypeViewAttribute(){
        return $this->typeViewArr [$this->type];
    }

    public function getStatusTextAttribute(){
        return $this->statusTextArr [$this->status];
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id')->withTrashed();
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id')->withTrashed();
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tag_course', 'course_id', 'tag_id');
    }
    public function files()
    {
        return $this->hasMany(File::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class, 'course_id');
    }
    public function units()
    {
        return $this->hasMany(Unit::class);
    }
}
