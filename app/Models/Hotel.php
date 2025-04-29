<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $table = 'hotels'; // (optional if table name matches model name)

    protected $fillable = [
        'name',
        'image',
        'description',
        'price',
    ];
}
