<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDocumentType extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'status',
        'type',
    ];

    public function userDocument()
    {
        return $this->hasMany(UserDocuments::class);
    }

    public function userDocumentTypeSelect()
    {
        return $this->hasOne(UserDocumentTypeSelect::class);
    }
}
