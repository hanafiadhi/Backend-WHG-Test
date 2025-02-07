<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\GlobalResponse;
use App\Models\Book;
use App\Models\BooksHistory;
use Illuminate\Support\Facades\DB;
use App\http\Resources\BookHistoryResource;

class BooksHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->query('status');
        $perPage = $request->query('per_page', 10);


        $booksHistory = BooksHistory::filterStatus($status)->paginate($perPage);

        return BookHistoryResource::collection($booksHistory);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'borrow_id'    => 'required|integer|min:1|max:10',
            'book_id'      => 'required|integer|exists:books,id',
        ]);

        // Cek jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 400);
        }


        $validated = $validator->validated();

        $book = Book::find($validated['book_id']);
        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'Book not found',
            ], 400);
        }

        if ($book->qty <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Book out of stock',
            ], 400);
        }


        $validated['start_date'] = round(microtime(true) * 1000);
        $validated['title'] = $book->title;

        try {
            DB::beginTransaction();


            $book->qty -= 1;
            $book->save();
            $orderNumber = 'ORD-' . strtoupper(uniqid());

            $booksHistory = BooksHistory::create([
                'borrow_id'    => $validated['borrow_id'],
                'start_date'   => $validated['start_date'],
                'order_number' => $orderNumber,
                'book_id'      => $validated['book_id'],
                'title'        => $validated['title'],
            ]);

            DB::commit();

            return new GlobalResponse(true, 'Success borrow book', $booksHistory, 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to borrow book',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $order_number)
    {
        $booksHistory = BooksHistory::where('order_number', $order_number)->first();
        if (!$booksHistory) {
            return response()->json([
                'success' => false,
                'message' => 'Borro book not found'
            ], 404);
        }

        return new GlobalResponse(true, 'Detail borrow book', $booksHistory, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_number'    => 'required|string|min:5',
        ]);

        // Cek jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 400);
        }


        $validated = $validator->validated();
        try {
            DB::beginTransaction();
            $booksHistory = BooksHistory::where('order_number', $validated['order_number'])->first();

            if (!$booksHistory) {
                return response()->json([
                    'success' => false,
                    'message' => 'Borrow book not found',
                ], 400);
            }
            $book = Book::find($booksHistory->book_id);
            $book->qty += 1;
            $book->save();

            $booksHistory->end_date = round(microtime(true) * 1000);
            $booksHistory->status = 2;
            $booksHistory->save();


            DB::commit();

            return new GlobalResponse(true, 'book successfully returned', $booksHistory, 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to borrow book',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
