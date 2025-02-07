<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Validation\ValidationException;

class Book extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'qty', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id')->withDefault();
    }

    public function booksHistory()
    {
        return $this->hasMany(BooksHistory::class, 'book_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $existing = Book::where('title', $model->title)
                ->where('id', '!=', $model->id)
                ->first();

            if ($existing) {
                throw ValidationException::withMessages([
                    'title' => __('already exists'),
                ]);
            }
        });
    }
}
