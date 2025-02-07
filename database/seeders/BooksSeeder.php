<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Category;

class BooksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::pluck('id')->toArray();

        if (empty($categories)) {
            $category = Category::create(['name' => 'Default Category']);
            $categories = [$category->id];
        }

        Book::create([
            'title' => 'Laravel for Beginners',
            'qty' => 10,
            'category_id' => $categories[array_rand($categories)],
        ]);

        Book::create([
            'title' => 'Mastering PHP',
            'qty' => 15,
            'category_id' => $categories[array_rand($categories)],
        ]);
    }
}
