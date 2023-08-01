<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\API\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route for user registration
Route::post('register', [AuthController::class, 'register']);

// Route for user login
Route::post('login', [AuthController::class, 'login']);

// Routes protected by the "auth:sanctum" middleware, requiring user authentication
Route::middleware(['auth:sanctum'])->group(function () {

    // Route for user logout
    Route::post('logout', [AuthController::class, 'logout']);

    // Route to add a new product to the database
    Route::post('product/add', [ProductController::class, 'store']);

    // Route to fetch all products from the database
    Route::get('products', [ProductController::class, 'index']);

    // Route to fetch a specific product by its ID from the database
    Route::get('product/{id}/show', [ProductController::class, 'show']);

    // Route to update an existing product in the database
    Route::put('product/{id}/update', [ProductController::class, 'update']);
    // Alternatively, you can use "POST" for updating if desired:
    // Route::post('product/{id}/update', [ProductController::class, 'update']);

    // Route to delete a product from the database
    Route::delete('product/{id}/delete', [ProductController::class, 'destroy']);
});
