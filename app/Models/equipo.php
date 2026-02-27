<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class equipo extends Model
{
    use HasFactory;

    // Nombre de la tabla (opcional si es el plural del modelo)
    protected $table = 'equipos';
    protected $primaryKey = 'equipo_id';

    // ESTO ES LO QUE FALTA:
    protected $fillable = [
        'nombre_completo',
        'nombre_corto',
        'abrebiatura',
        'descripcion',
        'imagen',
        'estado',
        'estado_campeonato',
    ];
}
