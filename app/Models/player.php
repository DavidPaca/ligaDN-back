<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class player extends Model
{
    use HasFactory;
    protected $primaryKey = 'player_id';
    protected $fillable = ['equipo_id', 'ci', 'name', 'last_name', 'birthdate', 'shirt_number', 'player_position', 'is_captain', 'status', 'created_at', 'updated_at'];
}
