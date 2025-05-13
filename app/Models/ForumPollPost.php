<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumPollPost extends Model
{
    use HasFactory;
    protected $table = 'forum_poll_post';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'question',
        'option_1',
        'option_2',
        'option_3',
        'option_4',
        'duration',
    ];
}
