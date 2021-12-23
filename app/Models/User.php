<?php

namespace App\Models;

use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'email',
        'is_admin',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $appends = [
        'tariff'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'tariff'=>'array'
    ];

    public function getCreatedAtAttribute($value): string
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $value)->format('d.m.y H:i');
    }

    public function getUpdatedAtAttribute($value): string
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $value)->format('d.m.y H:i');
    }

    public function isAdmin()
    {
        return $this->is_admin == 1;
    }

    protected static function booted()
    {
        static::created(function ($user) {
            $tariffBlocks = new TariffsUserBlocks();
            $tariffBlocks->user_id = $user->id;
            $tariffBlocks->tariff = 1;
            $tariffBlocks->save();
        });


    }
    public function getTariffAttribute($value)
    {
        if(!$value){
            $userService = UserService::getInstance();
            $value = $userService->getTariff($this);
        }

        return $value;
    }
    public function userTariff()
    {
        return $this->hasOne(TariffsUserBlocks::class, 'user_id','id');
    }
    public function userSavedPages()
    {
        return $this->hasMany(BlocksUser::class, 'user_id','id');
    }
    public function userDocuments()
    {
        return $this->hasMany(Documents::class, 'user_id','id');
    }
}

