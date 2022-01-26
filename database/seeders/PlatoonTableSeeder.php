<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
Use Carbon;

class PlatoonTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $platoons = [
            "Alpha", 
            "Bravo", 
            "Delta", 
            "Echo", 
            "Foxtrot", 
            "Golf",
            "Hotel"
        ];
        
        for ($i=0; $i < sizeof($platoons); $i++) { 
            DB::table('platoons')->insert([
                'company_id' => 1,
                'soldier_id' => 1,
                'name' => $platoons[$i],
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);
        }

        for ($i=0; $i < sizeof($platoons); $i++) { 
            DB::table('platoons')->insert([
                'company_id' => 2,
                'soldier_id' => 1,
                'name' => $platoons[$i],
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);
        }
    }
}
