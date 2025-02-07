<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BooksHistory extends Model
{
    use HasFactory;

    protected $table = 'books_history';

    protected $fillable = [
        'title',
        'borrow_id',
        'start_date',
        'end_date',
        'order_number',
        "book_id",
        'status',
    ];

    protected $casts = [
        'start_date' => 'integer',
        'end_date' => 'integer',
        'status' => 'integer',
    ];

    public function scopeFilterStatus($query, $status)
    {
        if (in_array($status, [1, 2])) {
            return $query->where('status', $status);
        }
        return $query;
    }

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id')->withDefault();
    }
}
