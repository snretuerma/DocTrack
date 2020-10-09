<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DivisionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $divisions = [
            ['name' => 'Division One'],
            ['name' => 'Division Two'],
            ['name' => 'Division Three'],
            ['name' => 'Admin'],
            ['name' => 'Staff'],
        ];
        DB::table('divisions')->insert($divisions);
    }
}
