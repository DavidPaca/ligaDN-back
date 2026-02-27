<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    use HasFactory;
    // Nombre de la tabla (opcional si es el plural del modelo)
    protected $table = 'categories';
    protected $primaryKey = 'category_id';

    // ESTO ES LO QUE FALTA:
    protected $fillable = [
        'details',
        'gender',
        'description',
        'status',
    ];
}
