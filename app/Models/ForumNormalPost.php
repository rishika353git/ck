<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumNormalPost extends Model
{
    use HasFactory;
    protected $table = 'forum_normal_post';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'description',
        'files',
        'upvote',
        'downvote',
        'share',
        'repost',
    ];
}
