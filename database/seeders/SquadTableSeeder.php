<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class SquadTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $squads = [
            "Armour",
            "Artillery",
            "Engineering",
            "Infantry",
            "Logistics",
            "Medical",
            "Commando",
            "Scout",
        ];

        for ($index=1; $index <= 7; $index++) { 
            for ($i=0; $i < 7; $i++) { 
                DB::table('squads')->insert([
                    'name' => $squads[$i],
                    'platoon_id' => $index,
                    'soldier_id' => 0,
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),
                ]);
            }
        }

        for ($index=8; $index <= 14; $index++) { 
            for ($i=0; $i < 7; $i++) { 
                DB::table('squads')->insert([
                    'name' => $squads[$i],
                    'platoon_id' => $index,
                    'soldier_id' => 0,
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),
                ]);
            }
        }
    }
}
