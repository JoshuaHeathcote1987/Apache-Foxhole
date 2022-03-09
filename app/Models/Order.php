<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Soldier;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'platoon_id',
        'head',
        'body',
        'image', 
    ];

    // Checks whether the person making the order has authority.
    public static function check(Soldier $soldier)
    {
        // opt being the option of which heirarchy you are checking, sqaud, platoon, company.
        $option = $opt;
    }

    public static function time_elapsed_string($datetime, $full = false) {
        $now = now();
        $ago = $datetime;
        $diff = $now->diff($ago);
    
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;
    
        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }
    
        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }
}
