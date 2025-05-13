<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumAnswer extends Model
{
    use HasFactory;
    protected $table = 'forum_answer';
    protected $primaryKey = 'id';
    protected $fillable = [
        'question_id',
        'user_id',
        'answer',
        'image',
    ];
}
