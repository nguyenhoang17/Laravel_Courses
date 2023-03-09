<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model implements Authenticatable
{
    use HasFactory,AuthenticableTrait;
    use SoftDeletes;
    protected $appends = ['gender_text'];
    protected $table = 'staffs';

    const STATUS_UNLOCKED = 0;
    const STATUS_LOCKED = 1;

    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;

    const ROLE_ADMIN = 'admin';
    const ROLE_EDITOR = 'editor';
    const ROLE_TEACHER = 'teacher';

    const PASSWORD_DEFAULT = 'Zent@edu.vn';


    protected $roleVNArr = [
        self::ROLE_ADMIN => 'Quản trị viên',
        self::ROLE_EDITOR => 'Biên tập viên',
        self::ROLE_TEACHER => 'Giảng viên',
    ];

    public function getRoleTextAttribute(){
        if ($this->role == 'admin'){
            return 'Quản trị viên';
        } elseif ($this->role == 'editor'){
            return 'Biên tập viên';
        } elseif ($this->role == 'teacher'){
            return 'Giảng viên';
        }
    }

    public function getRoleVnAttribute(){
        return $this->roleVNArr [$this->role];
    }


    const STATUS = [
        'DE_ACTIVE' => 1,
        'ACTIVE' => 0
    ];

    protected $statusArr = [
        self::STATUS_UNLOCKED => 'Tài khoản không khoá',
        self::STATUS_LOCKED => 'Tài khoản bị khoá'
    ];
    public function getStatusTextAttribute(){
        return $this->statusArr [$this->status];
    }

    static $genderArr = [
        self::GENDER_MALE => '1',
        self::GENDER_FEMALE => '2'
    ];
    public $genderTextArr = [
        self::GENDER_MALE => 'Nam',
        self::GENDER_FEMALE => 'Nữ'
    ];

    static $roleArr = [
        self::ROLE_ADMIN => 'admin',
        self::ROLE_EDITOR => 'editor',
        self::ROLE_TEACHER => 'teacher',
    ];

    public function getGenderTextAttribute(){
        if ($this->gender == '1'){
            return 'Nam';
        } elseif ($this->gender == '2'){
            return 'Nữ';
        }
    }


    public function chats()
    {
        return $this->hasMany(Chat::class);
    }

}

