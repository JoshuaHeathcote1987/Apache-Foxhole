<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Platoon extends Model
{
    use HasFactory;

    public function leader()
    {
        return $this->hasOne(Soldier::class);
    }

    public function squads()
    {
        return $this->hasMany(Squad::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
