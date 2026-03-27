<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MethodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $methods = [
            'GET',
            'POST',
            'PUT',
            'PATCH',
            'DELETE',
            'OPTIONS',
            'HEAD',
        ];

        foreach ($methods as $method) {
            DB::table('methods')->updateOrInsert(
                ['slug' => Str::lower($method)], // unique by slug
                [
                    'name' => $method,
                    'slug' => Str::lower($method),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
