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

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function squad()
    {
        return $this->belongsTo(Squad::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class, 'voted_soldier_id');
    }

    public function percentages()
    {
        return $this->hasMany(Percentage::class);
    }
}
