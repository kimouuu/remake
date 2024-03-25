<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDocumentType extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'status'
    ];

    public function userDocument()
    {
        return $this->hasMany(UserDocuments::class);
    }
}
