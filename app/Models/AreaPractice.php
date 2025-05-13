<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaPractice extends Model
{
    use HasFactory;
    protected $table = 'area_practice';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'status',
    ];
}
