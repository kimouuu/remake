<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
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
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'gender',
        'phone',
        'address',
        'province',
        'city',
        'district',
        'postal_code',
        'otp_code',
        'otp_expiry_time',

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

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_data', 'user_id', 'event_id');
    }
}
