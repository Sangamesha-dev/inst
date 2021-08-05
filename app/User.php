<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';


    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id');
    }

    public function getFullNameAttribute()
    {
        return "{$this->profile['first_name']} {$this->profile['last_name']}";
    }

    public function getPositionAttribute()
    {
        return "{$this->profile->latitude} {$this->profile->longitude}";
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'test_user_tags', 'user_id', 'tag_id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'mobile',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
