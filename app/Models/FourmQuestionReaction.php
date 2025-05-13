<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FourmQuestionReaction extends Model
{
    use HasFactory;
    protected $table = 'forum_question_reaction';
    protected $primaryKey = 'id';
    protected $fillable = [
        'question_id',
        'user_id',
        'status',
    ];
}
