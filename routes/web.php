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
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- PUBLIC ROUTES (Ai cũng vào được) ---
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// --- CART ROUTES ---
Route::prefix('cart')
    ->middleware('auth')
    ->group(function () {

        Route::get('/', [CartController::class, 'index'])->name('cart.index');
        Route::post('/add/{product}', [CartController::class, 'add'])->name('cart.add');
        Route::post('/clear', [CartController::class, 'clear'])->name('cart.clear');
        Route::put('/update/{id}', [CartController::class, 'update'])->name('cart.update');
        Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

});

// --- AUTHENTICATION ROUTES (Đăng nhập/Đăng ký/Quên mật khẩu) ---
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    
    // Quên mật khẩu
    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');


// --- USER ROUTES (Phải đăng nhập mới vào được) ---
Route::middleware('auth')->group(function () {
    
    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');

    // Feedback (Gửi phản hồi)
    Route::prefix('feedback')->group(function () {
        Route::get('/', [FeedbackController::class, 'create'])->name('feedback.create');
        Route::post('/', [FeedbackController::class, 'store'])->name('feedback.store');
    });

    // User Profile (Hồ sơ cá nhân)
    Route::prefix('user')->group(function () {
        // Xem và sửa thông tin
        Route::get('/profile', [ProfileController::class, 'edit'])->name('user.profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('user.profile.update');
        // Đổi mật khẩu
        Route::put('/password/update', [ProfileController::class, 'updatePassword'])->name('user.password.update');

        // Lịch sử đơn hàng (My Orders)
        Route::prefix('orders')->group(function () {
            Route::get('/', [UserOrderController::class, 'index'])->name('user.orders.index');
            Route::get('/{order}', [UserOrderController::class, 'show'])->name('user.orders.show');
            Route::put('/{order}/cancel', [UserOrderController::class, 'cancel'])->name('user.orders.cancel');
        });
    });

    // Reviews (Đánh giá sản phẩm)
    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});


// --- ADMIN ROUTES (Phải đăng nhập VÀ có quyền Admin) ---
// 👇 QUAN TRỌNG: Đã thêm middleware 'admin' vào đây
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Quản lý đánh giá (Reviews)
    

    // Quản lý sản phẩm (Products)
    Route::prefix('products')->group(function () {
        Route::get('/', [AdminProductController::class, 'index'])->name('admin.products.index');
        Route::get('/create', [AdminProductController::class, 'create'])->name('admin.products.create');
        Route::post('/', [AdminProductController::class, 'store'])->name('admin.products.store');
        Route::get('/{product}/edit', [AdminProductController::class, 'edit'])->name('admin.products.edit');
        Route::put('/{product}', [AdminProductController::class, 'update'])->name('admin.products.update');
        Route::delete('/{product}', [AdminProductController::class, 'destroy'])->name('admin.products.destroy');
    });
    
    // Quản lý đơn hàng (Orders)
    Route::prefix('orders')->group(function () {
        Route::get('/', [AdminOrderController::class, 'index'])->name('admin.orders.index');
        Route::get('/{order}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
        Route::post('/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.update-status');
    });
    
    // Quản lý phản hồi (Feedbacks)
    Route::prefix('feedbacks')->group(function () {
        Route::get('/', [FeedbackController::class, 'index'])->name('admin.feedbacks.index');
        Route::get('/{feedback}', [FeedbackController::class, 'show'])->name('admin.feedbacks.show');
        Route::delete('/{feedback}', [FeedbackController::class, 'destroy'])->name('admin.feedbacks.destroy');
    });
    
    // Quản lý người dùng (Users)
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('admin.users.index');
        Route::get('/create', [UserController::class, 'create'])->name('admin.users.create');
        Route::post('/', [UserController::class, 'store'])->name('admin.users.store');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy'); // Route này có thể dùng để xóa vĩnh viễn
        
        // --- CÁC HÀNH ĐỘNG ĐẶC BIỆT ---
        
        // Cấp/Hủy Admin
        Route::post('/{user}/make-admin', [UserController::class, 'makeAdmin'])->name('admin.users.make-admin');
        Route::post('/{user}/revoke-admin', [UserController::class, 'revokeAdmin'])->name('admin.users.revoke-admin');

        // 👇 ĐÃ SỬA: KHÓA / MỞ KHÓA (Dùng POST để khớp với form)
        Route::post('/{user}/lock', [UserController::class, 'lock'])->name('admin.users.lock');
        Route::post('/{user}/unlock', [UserController::class, 'unlock'])->name('admin.users.unlock');
});
});


// --- DEBUG ROUTE (Kiểm tra quyền) ---
Route::get('/check-admin', function() {
    return response()->json([
        'user_id' => Auth::id(),
        'role' => Auth::user()->role, // Đã sửa từ is_admin thành role
        'email' => Auth::user()->email
    ]);
})->middleware('auth');


// Fallback route for 404 errors (Đặt cuối cùng)
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});


Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/reviews', [AdminReviewController::class, 'index'])
        ->name('admin.reviews.index');

    Route::patch('/reviews/{review}/toggle', [AdminReviewController::class, 'toggle'])
        ->name('admin.reviews.toggle');
});
