<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Support\Facades\Route;

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

// Public routes for users
Route::prefix('auth')->group(function (): void {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::get('/products', [ProductController::class, 'index']);

// Public routes for admins
Route::prefix('admin/auth')->group(function (): void {
    Route::post('/register', [AdminAuthController::class, 'register']);
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::get('/roles', [AdminAuthController::class, 'getRoles']);
});

// Protected routes for users
Route::middleware(['auth:sanctum', 'role.user'])->prefix('auth')->group(function (): void {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
});

// Protected routes for cart
Route::middleware(['auth:sanctum'])->group(function (): void {
    Route::get('/cart', [CartController::class, 'viewCart']);
    Route::post('/cart', [CartController::class, 'addToCart']);
    Route::put('/cart/items/{cartItem}', [CartController::class, 'updateCartItem']);
    Route::delete('/cart/items/{cartItem}', [CartController::class, 'removeCartItem']);
    Route::delete('/cart', [CartController::class, 'clearCart']);
});

// Protected routes for admins
Route::middleware(['auth:sanctum', 'role.admin'])->prefix('admin/auth')->group(function (): void {
    Route::post('/logout', [AdminAuthController::class, 'logout']);
    Route::get('/me', [AdminAuthController::class, 'me']);
    Route::post('/refresh', [AdminAuthController::class, 'refresh']);
});

// Protected routes for products
Route::middleware(['auth:sanctum', 'role.admin'])->group(function (): void {
    Route::post('/products', [ProductController::class, 'store'])->middleware('permission:products.create');
    Route::get('/products/{product}', [ProductController::class, 'show'])->middleware('permission:products.read');
    Route::put('/products/{product}', [ProductController::class, 'update'])->middleware('permission:products.update');
});

// Test routes for authenticated users
Route::middleware(['auth:sanctum', 'role.user'])->group(function (): void {
    Route::get('/user/dashboard', function (#[CurrentUser] User $user) {
        return response()->json([
            'message' => 'Welcome to user dashboard',
            'user' => $user,
        ]);
    });
});

// Test routes for authenticated admins
Route::middleware(['auth:sanctum', 'role.admin'])->group(function (): void {
    Route::get('/admin/dashboard', function (#[CurrentUser] Admin $admin) {
        return response()->json([
            'message' => 'Welcome to admin dashboard',
            'admin' => $admin->load('role'),
        ]);
    });
});
