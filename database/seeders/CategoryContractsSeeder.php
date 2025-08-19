<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CategoryContract;


class CategoryContractsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CategoryContract::insert([
            ['name' => 'PEMASANGAN BARU', 'description' => null, 'created_at' => now()],
            ['name' => 'PERGANTIAN PK', 'description' => null, 'created_at' => now()],
            ['name' => 'RELOKASI', 'description' => null, 'created_at' => now()],
            ['name' => 'PERPANJANGAN', 'description' => null, 'created_at' => now()],
            ['name' => 'PENGURANGAN SEMENTARA', 'description' => null, 'created_at' => now()],
            ['name' => 'PENAMBAHAN UNIT', 'description' => null, 'created_at' => now()],
        ]);        
    }
}
