<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotarizedDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_hash',
        'document_id',
        'timestamp',
        'notary'
    ];
}
