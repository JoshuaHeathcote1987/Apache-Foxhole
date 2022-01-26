<?php

namespace App\Models;

use App\Models\Soldier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'user_id',
        'voting_soldier_id',
        'voted_soldier_id',
    ];
}
