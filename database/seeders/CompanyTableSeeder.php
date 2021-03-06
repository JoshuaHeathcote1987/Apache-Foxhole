<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class CompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('companies')->insert([
            'name'          => 'Live 1',
            'leader_id'    => null,
            'created_at'    => \Carbon\Carbon::now(),
            'updated_at'    => \Carbon\Carbon::now(),
        ]);

        DB::table('companies')->insert([
            'name' => 'Live 2',
            'leader_id' => null,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
    }
}
