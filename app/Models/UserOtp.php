<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserOtp extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'otp_type',
        'otp',
        'isVerified',
        'expired_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}