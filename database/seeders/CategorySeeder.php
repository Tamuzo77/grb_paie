<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['nom' => 'A'],
            ['nom' => 'A+'],
            ['nom' => 'B'],
            ['nom' => 'B+'],
        ];

        foreach ($categories as $category) {
            \App\Models\Category::create($category);
        }
    }
}
