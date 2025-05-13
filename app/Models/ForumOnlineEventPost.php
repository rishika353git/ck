<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumOnlineEventPost extends Model
{
    use HasFactory;
    protected $table = 'forum_online_event_post';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'image',
        'event_link',
        'event_name',
        'event_date_time',
        'description',
        'speakers',
    ];
}
