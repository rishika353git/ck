<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Premium extends Model
{
    use HasFactory;
    protected $table = 'premium';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'monthly_amount',
        'yearly_amount',
        'posts',
        'blue_tick',
        'status',
    ];

}
