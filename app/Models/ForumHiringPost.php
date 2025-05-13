<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumHiringPost extends Model
{
    use HasFactory;
    protected $table = 'forum_hiring_post';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'job_title',
        'entity_name',
        'workplace',
        'job_location',
        'job_description',
        'job_type',
    ];
}
