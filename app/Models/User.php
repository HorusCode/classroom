<?php

namespace App\Models;

use App\Traits\HasRolesAndPermissions;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasRolesAndPermissions, HasApiTokens;


    protected $guarded = ['id'];

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

    public function group()
    {
        return $this->belongsToMany(Group::class, 'students')->withTimestamps();
    }

    public function ratings() {
        return $this->hasMany(Rating::class);
    }

    public function createdTests() {
        return $this->hasMany(Testing::class, 'creator_id');
    }

    public function calendarEvents() {
        return $this->morphMany(CalendarEvent::class, 'parent');
    }



}
