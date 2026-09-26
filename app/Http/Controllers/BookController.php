<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Requests\CreateBookRequest;
use App\Http\Requests\UpdateBookRequest;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with('category');
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $allowedSorts = ['created_at', 'price', 'name'];

        $sort = in_array($request->query('sort'), $allowedSorts, true)
            ? $request->query('sort')
            : 'created_at';

        $order = $request->query('order', 'desc');

        return $query
            ->orderBy($sort, $order)
            ->paginate(10);
    }

    public function create(CreateBookRequest $request): JsonResponse
    {
        $data = $request->validated();

        $book = Book::create([
            'name'        => $data['name'],
            'description' => $data['description'] ?? null,
            'price'       => $data['price'],
            'quantity'    => $data['quantity'],
            'image'       => $data['image'] ?? null,
            'category_id' => $data['category_id'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tạo sách thành công',
            'data' => $book
        ], 201);
    }

    public function show($id)
    {
        $book = Book::with('category')->find($id);

        if (!$book) {
            return [
                'message' => 'Not found'
            ];
        }

        return [
            'data' => $book
        ];
    }

    public function update(UpdateBookRequest $request, $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy sách'
            ], 404);
        }

        $book->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật sách thành công',
            'data' => $book
        ], 200);
    }
    public function delete($id): array
    {
        $book = Book::find($id);

        if (!$book) {
            return [
                'message' => 'Not found'
            ];
        }

        $book->delete();

        return [
            'message' => 'deleted'
        ];
    }
}
