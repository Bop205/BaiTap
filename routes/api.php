<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\Api\BookJoinController;
use App\Http\Controllers\Api\AuthController;
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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::get('/books/inner-join', [BookJoinController::class, 'innerJoin']);
Route::get('/books/left-join', [BookJoinController::class, 'leftJoin']);
Route::get('/books/join-filter', [BookJoinController::class, 'joinFilter']);

Route::get('/books', [BookController::class, 'index']);
Route::get('/books/{id}', [BookController::class, 'show']);
Route::put('/books/{id}', [BookController::class, 'update']);

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::post('/books', [BookController::class, 'create']);
    Route::delete('/books/{id}', [BookController::class, 'delete']);
});

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
