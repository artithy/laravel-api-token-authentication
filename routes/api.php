<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/registration', [UserController::class, 'store']);
Route::get('/profile', [UserController::class, 'getProfile']);
Route::post('/logout', [UserController::class, 'logout']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/product', [ProductController::class, 'store']);
Route::post('/category', [CategoryController::class, 'store']);
Route::get('/categories', [CategoryController::class, 'getAllCatagories']);
Route::get('/products', [ProductController::class, 'productsWithCategories']);
