<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Selections extends Model
{
    use HasFactory;
    protected $table = 'selection';
    protected $fillable = [
        'id',
        'uuid',
        'students_id',
        'programs_a',
        'programs_b',
        'accept',
        'active',
    ];
}
