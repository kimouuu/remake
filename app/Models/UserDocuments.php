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
        'input',
        'verified_at',
        'verified_by',
    ];
    protected $table = 'user_documents';

    public function user()
    {
        return $this->belongsTo(User::class,);
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function types()
    {
        return $this->belongsTo(UserDocumentType::class, 'user_document_type_id');
    }
}
