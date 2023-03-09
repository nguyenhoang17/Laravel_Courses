<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    const GENDER_MALE = 1;
    const GENDER_FEMALE = 0;
    const STATUS = [
        'ACTIVE' => 1,
        'DE_ACTIVE' => 0,
        'UN_CONFIRM' => 2
    ];
    const STATUS_UNLOCKED = 1;
    const STATUS_LOCKED = 0;
    protected $appends = ['status_text','gender_text'];
    protected $table = 'users';
    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'phone',
        'gender',
        'status'
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    static $genderArr = [
        self::GENDER_MALE => '1',
        self::GENDER_FEMALE => '0'
    ];
    public $genderTextArr = [
        self::GENDER_MALE => 'Nam',
        self::GENDER_FEMALE => 'Nữ'
    ];
    protected $statusArr = [
        self::STATUS_UNLOCKED => 'Tài khoản đang hoạt động',
        self::STATUS_LOCKED => 'Tài khoản bị khoá',
        self::STATUS['UN_CONFIRM'] => 'Chưa kích hoạt'
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    public function getGenderTextAttribute()
    {
        if($this->gender == self::GENDER_MALE){
            $name = 'Nam';
        }
        else{
            $name = 'Nữ';
        }
        return $name;
    }
    public function getStatusTextAttribute()
    {
        if($this->status == self::STATUS_UNLOCKED){
            $name = 'Tài khoản đang hoạt động';
        }else if($this->status == self::STATUS['UN_CONFIRM']){
            $name = 'Chưa kích hoạt';
        } else{
            $name = 'Tài khoản bị khoá';
        }
        return $name;
    }
    public function chats()
    {
        return $this->hasMany(Chat::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

}
