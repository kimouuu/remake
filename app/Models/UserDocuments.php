<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDocuments extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'user_document_type_id',
        'image',
    ];
    protected $table = 'user_documents';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function type()
    {
        return $this->belongsTo(UserDocumentType::class);
    }
}
