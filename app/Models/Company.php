<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    public function leader()
    {
        return $this->hasOne(Soldier::class);
    }

    public function platoons()
    {
        return $this->hasMany(Platoon::class);
    }
}
