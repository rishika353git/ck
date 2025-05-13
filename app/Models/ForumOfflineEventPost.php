<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumOfflineEventPost extends Model
{
    use HasFactory;
    protected $table = 'forum_offline_event_post';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'image',
        'event_name',
        'event_date_time',
        'venue_address',
        'event_link',
        'description',
        'speakers',
    ];
}
