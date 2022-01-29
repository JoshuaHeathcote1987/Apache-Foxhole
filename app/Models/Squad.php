<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Squad extends Model
{
    use HasFactory;

    public function soldiers()
    {
        return $this->hasMany(Soldier::class);
    }

    public function platoon()
    {
        return $this->belongsTo(Platoon::class);
    }
}
