<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Models\Category;
use App\Models\Book;
use App\Models\User;
use App\Models\Profile;
use App\Models\Student;
use App\Models\Course;

Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'message' => 'API is running'
    ]);
});

Route::get('/books', [BookController::class, 'index']);
Route::post('/books', [BookController::class, 'create']);
Route::get('/books/{id}', [BookController::class, 'show']);
Route::put('/books/{id}', [BookController::class, 'update']);
Route::delete('/books/{id}', [BookController::class, 'delete']);

Route::get('/test-category/{id}', function ($id) {
    return Category::with('books')->findOrFail($id);
});
Route::get('/test-book/{id}', function ($id) {
    return Book::with('category')->findOrFail($id);
});

Route::get('/test-user/{id}', function ($id) {
    return User::with('profile')->findOrFail($id);
});
Route::get('/test-profile/{id}', function ($id) {
    return Profile::with('user')->findOrFail($id);
});

Route::get('/test-student/{id}', function ($id) {
    return Student::with('courses')->findOrFail($id);
});
Route::get('/test-course/{id}', function ($id) {
    return Course::with('students')->findOrFail($id);
});
