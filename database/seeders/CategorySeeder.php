<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Category::query()->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');


        // Tambahkan data dummy
        Category::insert([
            ['name' => 'Novel'],
            ['name' => 'Cergam'],
            ['name' => 'Komik'],
            ['name' => 'Antologi'],
            ['name' => 'Tafsir'],
        ]);
    }
}
