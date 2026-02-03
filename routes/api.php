<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\User\OrderController as UserOrderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ReviewController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);
Route::get('/products/search/{name}', [ProductController::class, 'search']);

// Authentication routes
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // User profile
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [LoginController::class, 'logout']);

    // Cart
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart/add/{product}', [CartController::class, 'add']);
    Route::put('/cart/update/{id}', [CartController::class, 'update']);
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove']);
    Route::post('/cart/clear', [CartController::class, 'clear']);

    // Checkout
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');

    // Orders
    Route::get('/orders', [UserOrderController::class, 'index'])->name('user.orders.index');
    Route::get('/orders/{order}', [UserOrderController::class, 'show'])->name('user.orders.show');

    // Reviews
    Route::post('/products/{product}/reviews', [ReviewController::class, 'store']);
    Route::put('/reviews/{review}', [ReviewController::class, 'update']);
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy']);

    // Feedback
    Route::post('/feedback', [FeedbackController::class, 'store']);

    // User profile update
    Route::put('/profile', [UserController::class, 'updateProfile']);
});

// Admin routes
Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {
    // Products
    Route::apiResource('products', ProductController::class)->except(['index', 'show']);

    // Orders
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
    Route::post('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.update-status');

    // Users
    Route::apiResource('users', UserController::class);
    Route::post('/users/{user}/make-admin', [UserController::class, 'makeAdmin']);
    Route::post('/users/{user}/revoke-admin', [UserController::class, 'revokeAdmin']);

    // Reviews
    Route::get('/reviews', [ReviewController::class, 'adminIndex']);
    Route::post('/reviews/{review}/approve', [ReviewController::class, 'approve']);
    Route::post('/reviews/{review}/reject', [ReviewController::class, 'reject']);
    Route::delete('/reviews/{review}', [ReviewController::class, 'adminDestroy']);

    // Feedback
    Route::get('/feedbacks', [FeedbackController::class, 'index']);
    Route::get('/feedbacks/{feedback}', [FeedbackController::class, 'show']);
    Route::delete('/feedbacks/{feedback}', [FeedbackController::class, 'destroy']);
});