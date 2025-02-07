<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\BooksHistoryController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
// Route::post('/category', App\Http\Controllers\Api\CategoryController::class);
Route::apiResource('/category', CategoryController::class);
Route::apiResource('/books', BookController::class);
Route::post('/borrow-book', [BooksHistoryController::class, 'store']);
Route::get('/borrow-books', [BooksHistoryController::class, 'index']);
Route::patch('/borrow-book', [BooksHistoryController::class, 'update']);
Route::get('/borrow-book/{order_number}', [BooksHistoryController::class, 'show']);
