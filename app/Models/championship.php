<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class championship extends Model
{
    use HasFactory;
    protected $primaryKey = 'championship_id';

    // 2. LA SOLUCIÓN: Lista de campos que se pueden llenar/editar
    protected $fillable = [
        'name',
        'type',
        'start_date',
        'end_date',
        'image',
        'status_championship',
        'status',
        'description',
        'user_id'
    ];
}
