<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ProtocolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('protocols')->insert([
            [
                'name' => 'HTTP',
                'protocol'=> 'http',
                'description' => 'Web protocol',
                'type' => 'web',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'    => 'HTTPS',
                'protocol'=> 'https',
                'description' => 'Web protocol Secure access',
                'type' => 'web',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'FTP',
                'protocol'=> 'ftp',
                'description' => 'File transfer protocol',
                'type' => 'network',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'SSH',
                'protocol'=> 'ssh',
                'description' => 'Secure shell access',
                'type' => 'security',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
