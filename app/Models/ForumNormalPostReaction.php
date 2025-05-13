<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumNormalPostReaction extends Model
{
    use HasFactory;
    protected $table = 'forum_normal_post_reaction';
    protected $primaryKey = 'id';
    protected $fillable = [
        'post_id',
        'user_id',
        'status',
    ];
}
