<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumNormalPostCommentReply extends Model
{
    use HasFactory;
    protected $table = 'forum_normal_post_comment_reply';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'post_id',
        'comment_id',
        'reply',
    ];
}
