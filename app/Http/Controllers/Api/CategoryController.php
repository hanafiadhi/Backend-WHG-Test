<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GlobalResponse;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::latest()->paginate(5);
        return new GlobalResponse(true, 'List Data Category', $category, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'failed add category',
                'error'   => $validator->errors()
            ], 400);
        }


        $Categories = Category::create($request->all());
        return new GlobalResponse(true, 'success create new categories!', $Categories, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        if (!is_numeric($id)) {
            return response()->json([
                'success' => false,
                'message' => 'failed find category',
                'error'   => [
                    'id' => ['The id field must be a number.']
                ]
            ], 400);
        }

        $category = Category::find($id);
        if (!$category) {

            return response()->json([
                'success' => false,
                'message' => 'category not found'
            ], 404);
        }

        return new GlobalResponse(true, 'detail categories', $category, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
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

        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $category = Category::find($id);
        if (!$category) {

            return response()->json([
                'success' => false,
                'message' => 'category not found'
            ], 404);
        }
        $category->update($request->all());
        return new GlobalResponse(true, 'success update new categories!', $category, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        if (!is_numeric($id)) {
            return response()->json([
                'success' => false,
                'message' => 'failed remove category',
                'error'   => [
                    'id' => ['The id field must be a number.']
                ]
            ], 400);
        }
        $category = Category::find($id);
        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'category not found'
            ], 404);
        }
        $category->delete();
        return new GlobalResponse(true, 'success delete new categories!', null, 200);
    }
}
