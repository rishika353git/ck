<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumOccasionPost extends Model
{
    use HasFactory;
    protected $table = 'forum_occasion_post';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'give_kudos',
        'position',
        'certification',
        'work_anniversary',
        'education_milestone',

    ];
}
