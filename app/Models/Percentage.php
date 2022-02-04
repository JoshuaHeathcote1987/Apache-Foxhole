<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Percentage extends Model
{
    use HasFactory;

    protected $fillable = [
        'soldier_id',
        'category',
        'percentage',
        'count',
    ];

    public function soldier()
    {
        return $this->belongsTo(Soldier::class);
    }

    public function percentages() 
    {
        return $this->belongsTo(Soldier::class);
    }
}
