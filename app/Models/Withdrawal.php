<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    use HasFactory;
    protected $table = 'withdrawal';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'coins',
        'request_status',
    ];
}
