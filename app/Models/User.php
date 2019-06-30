<?php

namespace App\Models;

use App\Http\Traits\ModelQueryExtend;
use App\Models\Ord\OrdOrder;
use App\Models\User\UserMessage;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements JWTSubject
{

    use HasRoles,Notifiable,ModelQueryExtend;

    const USER_STATUS_OPEN = 1;
    const USER_STATUS_STOP = 0;
    const USER_STATUS_DELETE = 9;

    const USER_TYPE_ADMIN = 1;
    const USER_TYPE_TENANT = 2;
    const USER_TYPE_STAFF = 4;
    const USER_TYPE_MEMBER = 8;

    protected $appends = ['type_name','guard_name'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'nickname', 'email', 'password','mobile','openid','type'
    ];

    public function getGuardNameAttribute(){

        return [
            User::USER_TYPE_ADMIN => config('app.guard.admin'),
            User::USER_TYPE_TENANT => config('app.guard.tenant'),
            User::USER_TYPE_STAFF => config('app.guard.tenant'),
            User::USER_TYPE_MEMBER => config('app.guard.api'),
        ][$this->type];
    }

    public function getTypeNameAttribute(){
        return [
            self::USER_TYPE_ADMIN => '管理员',
            self::USER_TYPE_TENANT => '租客',
            self::USER_TYPE_STAFF => '员工',
            self::USER_TYPE_MEMBER => '会员',
        ][$this->type];
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * 获取用户订单
     */
    public function order(){
        return $this->hasMany(OrdOrder::class,'user_id');
    }

    /**
     * 获取用户订单
     */
    public function message(){
        return $this->hasMany(UserMessage::class,'user_id');
    }
}
