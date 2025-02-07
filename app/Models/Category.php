<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $existing = Category::where('name', $model->name)
                ->where('id', '!=', $model->id)
                ->first();

            if ($existing) {
                throw ValidationException::withMessages([
                    'name' => __('already exists'),
                ]);
            }
        });
    }

    public function books()
    {
        return $this->hasMany(Book::class, 'category_id');
    }
}
