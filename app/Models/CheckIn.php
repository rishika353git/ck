<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckIn extends Model
{
    use HasFactory;
    protected $table = 'checkin';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'court',
        'sub_court',
        'visit_time',
        'expiry_time',
        'reason_to_visit',
    ];
}
