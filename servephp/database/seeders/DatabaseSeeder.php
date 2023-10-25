<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

use App\Models\Programs;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('programs')->insert([
            'uuid' => (string) Str::uuid(),
            'name' => 'ADSO',
            'image' => 'https://placehold.co/600x400',
            'description' => 'lorem ipsum algo',
            'active' => true,
        ]);
        DB::table('programs')->insert([
            'uuid' => (string) Str::uuid(),
            'name' => 'TALENTO HUMANO',
            'image' => 'https://placehold.co/600x400',
            'description' => 'lorem ipsum talento humano',
            'active' => true,
        ]);
    }
}
