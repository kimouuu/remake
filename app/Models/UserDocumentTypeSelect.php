<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDocumentTypeSelect extends Model
{
    use HasFactory;

    protected $table = 'user_document_type_select';
    protected $fillable = [
        'user_document_type_id',
        'select_option'
    ];

    public function userDocumentType()
    {
        return $this->belongsTo(UserDocumentType::class);
    }
}
