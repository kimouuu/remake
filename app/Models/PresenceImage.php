<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresenceImage extends Model
{
    use HasFactory;
    protected $table = 'presence_images';

    public function presence()
    {
        return $this->belongsTo(Presence::class, 'presence_id', 'id');
    }
}
