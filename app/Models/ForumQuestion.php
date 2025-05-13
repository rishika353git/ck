<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumQuestion extends Model
{
    use HasFactory;
    protected $table = 'forum_question';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'title',
        'categories',
        'file',
        'upvote',
        'downvote',
    ];
}

