<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $table = 'profile';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'year_of_enrollment',
        'current_designation',
        'previous_experiences',
        'home_courts',
        'area_of_practice',
        'law_school',
        'batch',
        'linkedin_profile',
        'description',
        'profile_tagline',
        'total_judgments_given',
        'top_5_skills',
        'total_judgment_asked',
        'total_sitation_asked',
        'total_sitation_given',
        'total_follow',
        'total_followers',
        'questions_asked',
        'answers_given',
        'total_earning',
        'total_spend',
        'post',
        'drafts_uploaded',
        'rating_average',
    ];
}
