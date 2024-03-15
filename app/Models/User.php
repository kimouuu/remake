<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'fullname',
        'email',
        'email_verified_at',
        'password',
        'role',
        'gender',
        'date_birth',
        'phone',
        'phone_verified_at',
        'address',
        'province',
        'city',
        'district',
        'postal_code',
        'otp_code',
        'otp_expiry_time',
        'status',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function message()
    {
        return $this->hasMany(Message::class);
    }

    public function document()
    {
        return $this->hasOne(UserDocuments::class, 'user_id');
    }

    public function userDocument()
    {
        return $this->hasMany(UserDocuments::class);
    }
    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_data', 'user_id', 'event_id');
    }
}
