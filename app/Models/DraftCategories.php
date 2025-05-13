<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DraftCategories extends Model
{
    use HasFactory;
    protected $table = 'draft_categories';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
    ];
}
