<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class referee_sanction extends Model
{
    use HasFactory;
    // Nombre de la tabla (opcional si es el plural del modelo)
    protected $table = 'referee_sanctions';
    protected $primaryKey = 'referee_sanction_id';

    // ESTO ES LO QUE FALTA:
    protected $fillable = [
        'details',
        'date_sanction',
        'description',
        'price',
        'word_initials',
        'status',
    ];
}
