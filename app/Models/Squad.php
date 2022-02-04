<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Squad extends Model
{
    use HasFactory;

    public function leader()
    {
        return $this->hasOne(Soldier::class, 'id', 'leader_id');
    }

    public function soldiers()
    {
        return $this->hasMany(Soldier::class);
    }

    public function platoon()
    {
        return $this->belongsTo(Platoon::class);
    }
}
