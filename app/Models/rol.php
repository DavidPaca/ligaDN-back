<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rol extends Model
{
    use HasFactory;
    // Nombre de la tabla (opcional si es el plural del modelo)
    protected $table = 'rols';
    protected $primaryKey = 'rol_id';

    // ESTO ES LO QUE FALTA:
    protected $fillable = [
        'name',
        'description',
        'status',
    ];        
}
