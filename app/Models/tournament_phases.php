<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tournament_phases extends Model
{
    use HasFactory;
    protected $table = 'tournament_phases';
    protected $fillable = [
        'details',
        'description',
        'status'
    ];
}
