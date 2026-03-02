<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class championship_categories extends Model
{
    use HasFactory;
    protected $primaryKey = 'championship_category_id';
    protected $fillable = ['championship_id', 'category_id', 'max_teams', 'status'];
}
