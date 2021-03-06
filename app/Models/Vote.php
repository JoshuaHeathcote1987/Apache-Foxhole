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
        'voting_soldier_id',
        'voted_soldier_id',
    ];

    public function voting_soldier()
    {
        return $this->belongsTo(Soldier::class);
    }

    public  function voted_soldier()
    {
        return $this->belongsTo(Soldier::class);
    }

    public function vote()
    {
        return $this->belongsTo(Soldier::class, 'id', 'voted_soldier_id');
        
    }
}
