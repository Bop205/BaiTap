<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

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

    public function create(Request $request): array
    {
        $data = $request->all();

        $book = Book::create([
            'name'        => $data['name'],
            'description' => $data['description'] ?? null,
            'price'       => $data['price'],
            'quantity'    => $data['quantity'],
            'image'       => $data['image'] ?? null,
            'category_id' => $data['category_id'],
        ]);

        return [
            'message' => 'created',
            'data'    => $book
        ];
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

    public function update(Request $request, $id): array
    {
        $book = Book::find($id);

        if (!$book) {
            return [
                'message' => 'Not found'
            ];
        }

        $data = $request->all();

        $book->update([
            'name'        => $data['name'] ?? $book->name,
            'description' => $data['description'] ?? $book->description,
            'price'       => $data['price'] ?? $book->price,
            'quantity'    => $data['quantity'] ?? $book->quantity,
            'image'       => $data['image'] ?? $book->image,
            'category_id' => $data['category_id'] ?? $book->category_id,
        ]);

        return [
            'message' => 'updated',
            'data'    => $book
        ];
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
