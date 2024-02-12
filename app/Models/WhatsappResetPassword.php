<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsappPasswordReset extends Model
{
    use HasFactory;
    protected $fillable = [
        'phone_number',
        'token ',
    ];

    protected $table = 'reset_password';
}
