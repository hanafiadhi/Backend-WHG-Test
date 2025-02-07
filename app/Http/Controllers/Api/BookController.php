<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\GlobalResponse;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::select('books.id', 'books.title', 'books.qty', 'categories.name as category', 'books.created_at', 'books.updated_at')
            ->join('categories', 'books.category_id', '=', 'categories.id')
            ->latest()
            ->paginate(5);

        return new GlobalResponse(true, 'List data books', $books, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'qty' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'failed add book',
                'error'   => $validator->errors()
            ], 400);
        }

        $book = Book::create($request->all());
        return new GlobalResponse(true, 'success add book', $book, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        if (!is_numeric($id)) {
            return response()->json([
                'success' => false,
                'message' => 'failed add category',
                'error'   => [
                    'id' => ['The id field must be a number.']
                ]
            ], 400);
        }

        $book = Book::with('category')->find($id);
        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'book not found'
            ], 404);
        }

        return new GlobalResponse(true, 'detail book', $book, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (!is_numeric($id)) {
            return response()->json([
                'success' => false,
                'message' => 'failed update category',
                'error'   => [
                    'id' => ['The id field must be a number.']
                ]
            ], 400);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'qty' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'failed add book',
                'error'   => $validator->errors()
            ], 400);
        }

        $book = Book::find($id);
        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'book not found'
            ], 404);
        }

        $book->update([
            'title' => $request->title,
            'qty' => $request->qty,
            'category_id' => $request->category_id
        ]);

        return new GlobalResponse(true, 'success update new book!', $book, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!is_numeric($id)) {
            return response()->json([
                'success' => false,
                'message' => 'failed update category',
                'error'   => [
                    'id' => ['The id field must be a number.']
                ]
            ], 400);
        }
        $book = Book::find($id);
        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'book not found'
            ], 404);
        }
        $book->delete();
        return new GlobalResponse(true, 'success delete new book!', null, 200);
    }
}
