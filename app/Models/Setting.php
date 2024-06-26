<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'history',
        'community_bio',
        'image',
        'video',
        'community_structure',
        'slogan',
        'community_name',
        'endpoint',
        'api_key',
        'sender',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
