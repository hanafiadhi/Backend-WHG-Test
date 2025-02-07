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


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (Book::where('title', $model->title)->exists()) {
                throw ValidationException::withMessages([
                    'title' => __('already exists'),
                ]);
            }
        });
    }
}
