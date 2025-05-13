<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionHistory extends Model
{
    use HasFactory;
    protected $table = 'transaction_history';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'type',
        'transaction_id',
        'amount',
        'used_for',
    ];
}
