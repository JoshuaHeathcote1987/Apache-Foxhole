<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soldier extends Model
{
    use HasFactory;

    protected $fillable = [
        'squad_id',
        'user_id',
        'game_name', 
        'game_name',
        'steam_id',
        'instagram',
        'twitter',
        'facebook',
        'twitch',
    ];
}
