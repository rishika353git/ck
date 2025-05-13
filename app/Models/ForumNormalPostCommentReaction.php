<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumNormalPostCommentReaction extends Model
{
    use HasFactory;
    protected $table = 'forum_normal_post_comment_reaction';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'comment_id',
        'status',
    ];
}
