<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert([
            ['category' => 'Cabut', 'created_at' => now()],
            ['category' => 'Perpanjangan', 'created_at' => now()],
            ['category' => 'PPS', 'created_at' => now()],
            ['category' => 'Relokasi Ke', 'created_at' => now()],
            ['category' => 'Relokasi Dari', 'created_at' => now()],
        ]);
    }
}
