<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumNormalPostComment extends Model
{
    use HasFactory;
    protected $table = 'forum_normal_post_comment';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'post_id',
        'comment',
        'upvote',
        'downvote',
    ];
}
