<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vocalia extends Model
{
    use HasFactory;
    // Nombre de la tabla (opcional si es el plural del modelo)
    protected $table = 'vocalias';
    protected $primaryKey = 'vocalia_id';

    // ESTO ES LO QUE FALTA:
    protected $fillable = [
        'details',
        'price',
        'description',
        'date_vacalia',
        'status',
    ];
}
