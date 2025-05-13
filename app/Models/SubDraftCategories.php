<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubDraftCategories extends Model
{
    use HasFactory;
    protected $table = 'sub_draft_categories';
    protected $primaryKey = 'id';
    protected $fillable = [
        'draft_id',
        'name',
    ];
}
