<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books_history', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('borrow_id');
            $table->bigInteger('start_date');
            $table->bigInteger('end_date')->nullable();
            $table->string('order_number');
            $table->foreignId('book_id')
                ->nullable()
                ->constrained('books')
                ->nullOnDelete()
                ->cascadeOnUpdate();
            $table->enum('status', [1, 2])->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books_history');
    }
};
