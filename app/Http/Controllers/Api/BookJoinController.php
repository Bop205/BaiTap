<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookJoinController extends Controller
{
    public function innerJoin()
    {
        $books = DB::table('books')
            ->join('categories', 'books.category_id', '=', 'categories.id')
            ->select('books.id', 'books.name', 'books.price', 'books.quantity', 'categories.name as category_name')
            ->get();

        return response()->json($books);
    }

    public function leftJoin()
    {
        $books = DB::table('books')
            ->leftJoin('categories', 'books.category_id', '=', 'categories.id')
            ->select('books.id', 'books.name', 'books.price', 'books.quantity', 'categories.name as category_name')
            ->get();

        return response()->json($books);
    }

    public function joinFilter(Request $request)
    {
        $query = DB::table('books')
            ->join('categories', 'books.category_id', '=', 'categories.id')
            ->select('books.id', 'books.name', 'books.price', 'books.quantity', 'categories.name as category_name');

        if ($request->filled('search')) {
            $query->where('books.name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category_id')) {
            $query->where('books.category_id', $request->category_id);
        }

        if ($request->sort == 'asc') {
            $query->orderBy('books.price', 'asc');
        } elseif ($request->sort == 'desc') {
            $query->orderBy('books.price', 'desc');
        } elseif ($request->sort == 'category') {
            $query->orderBy('categories.name', 'asc');
        } else {
            $query->orderBy('books.created_at', 'desc');
        }

        return response()->json($query->get());
    }
}
