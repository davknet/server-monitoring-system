<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HealthStratus extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('statuses')->insert([
            'name' => 'Healthy',
            'description' => 'Server is functioning correctly',
            'is_active' => true,
        ]);

        DB::table('statuses')->insert([
            'name' => 'Unhealthy',
            'description' => 'Server is not functioning correctly',
            'is_active' => true,
        ]);

        DB::table('statuses')->insert([
            'name' => 'Unknown',
            'description' => 'Server status is unknown',
            'is_active' => true,
        ]);
    }
}
