<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BooksHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('books_history')->insert([
            [
                'title' => 'The Great Gatsby',
                'borrow_id' => 1,
                'start_date' => now()->timestamp,
                'end_date' => now()->addDays(7)->timestamp,
                'order_number' => Str::random(10),
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => '1984',
                'borrow_id' => 2,
                'start_date' => now()->timestamp,
                'end_date' => now()->addDays(10)->timestamp,
                'order_number' => Str::random(10),
                'status' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'To Kill a Mockingbird',
                'borrow_id' => 3,
                'start_date' => now()->timestamp,
                'end_date' => null,
                'order_number' => Str::random(10),
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
