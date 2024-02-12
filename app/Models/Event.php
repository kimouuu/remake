<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(User::class, 'event_user', 'event_id', 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(CommentPost::class);
    }

    public function eventData()
    {
        return $this->hasMany(EventData::class, 'event_id');
    }
}
