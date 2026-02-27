<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class playing_schedule extends Model
{
    use HasFactory;
    // Nombre de la tabla (opcional si es el plural del modelo)
    protected $table = 'playing_schedules';
    protected $primaryKey = 'playing_schedule_id';

    // ESTO ES LO QUE FALTA:
    protected $fillable = [
        'details',
        'description',
        'status',
    ];
}
