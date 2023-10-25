<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Programs extends Model
{
    use HasFactory;
    protected $table = 'programs';
    protected $fillable = [
        'id',
        'uuid',
        'name',
        'image',
        'description',
        'active',
    ];
}
