<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCourt extends Model
{
    use HasFactory;
    protected $table = 'sub_court';
    protected $primaryKey = 'id';
    protected $fillable = [
        'court_id',
        'name',
    ];
}
