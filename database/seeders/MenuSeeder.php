<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Menu::insert([
            ['name' => 'Pasang Baru', 'created_at' => now()],
            ['name' => 'DC', 'created_at' => now()],
            ['name' => 'Relokasi', 'created_at' => now()],
            ['name' => 'Exit Sementara', 'created_at' => now()],
            ['name' => 'Putus', 'created_at' => now()],
            ['name' => 'Geser', 'created_at' => now()],
        ]);
    }
}
