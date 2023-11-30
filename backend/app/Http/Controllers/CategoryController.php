<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::when(auth('sanctum')->user()->role !== 'admin', function ($query) {
            return $query->where('created_by', auth('sanctum')->user()->id);
        })->orderBy('created_at', 'desc')->with('createdBy')->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Kategori berhasil ditampilkan',
            'data' => $categories
        ]);
    }

    public function store(CategoryRequest $request)
    {
        $validated = $request->validated();
        $validated['created_by'] = auth('sanctum')->user()->role === 'admin' ? $validated['created_by'] : auth('sanctum')->user()->id;
        $category = Category::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Kategori berhasil ditambahkan',
            'data' => $category
        ], 201);
    }

    public function show(Category $category)
    {
        $this->checkAccess($category);
        $category->load('createdBy');

        return response()->json([
            'status' => 'success',
            'message' => 'Kategori berhasil ditampilkan',
            'data' => $category
        ]);
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $this->checkAccess($category);

        $validated = $request->validated();
        $validated['created_by'] = auth('sanctum')->user()->role === 'admin' ? $validated['created_by'] : auth('sanctum')->user()->id;
        $category->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Kategori berhasil diperbarui',
            'data' => $category
        ]);
    }

    public function destroy(Category $category)
    {
        $this->checkAccess($category);

        $category->reminders()->delete();
        $category->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Kategori berhasil dihapus'
        ]);
    }

    private function checkAccess(Category $category)
    {
        if (auth('sanctum')->user()->role !== 'admin' && $category->created_by !== auth('sanctum')->user()->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda tidak memiliki hak akses'
            ], 403);
        }
    }
}
