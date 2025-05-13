<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    use HasFactory;
    protected $table = 'polls';
    protected $primaryKey = 'id';
    protected $fillable = [
        'poll_id',
        'ask_a_question',
        'choice1',
        'choice2',
        'choice3',
        'choice4',
        'poll_duration',
    ];
}
