<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\ProductController as UserProductController;
use App\Http\Controllers\User\WishlistController as UserWishlistController;
use App\Http\Controllers\User\OrderController as UserOrderController;
use App\Http\Controllers\User\ProfileController as UserProfileController;
use Illuminate\Support\Facades\Route;

// Home Route - Redirect based on authentication
Route::get('/', function () {
    if (auth()->check()) {
        $user = auth()->user();
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('user.dashboard');
    }
    return redirect()->route('login');
});

// Dashboard Route - Redirect based on role
Route::get('/dashboard', function () {
    if (auth()->check()) {
        $user = auth()->user();
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('user.dashboard');
    }
    return redirect()->route('login');
})->middleware('auth')->name('dashboard');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Master Modules
    Route::resource('departments', DepartmentController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('brands', App\Http\Controllers\Admin\BrandController::class);
    Route::resource('units', UnitController::class);
    Route::resource('products', AdminProductController::class);
    
    // Orders Management
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::put('orders/{order}', [AdminOrderController::class, 'update'])->name('orders.update');
    
    // Reports
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    
    // User Management
    Route::get('users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::get('users/{user}', [App\Http\Controllers\Admin\UserController::class, 'show'])->name('users.show');
    Route::get('users/{user}/edit', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('users.edit');
    Route::put('users/{user}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('users.update');
    Route::put('users/{user}/toggle-status', [App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])->name('users.toggle-status');
    
    // Settings
    Route::get('settings', [App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings.index');
    Route::put('settings/profile', [App\Http\Controllers\Admin\SettingsController::class, 'updateProfile'])->name('settings.profile');
    Route::put('settings/password', [App\Http\Controllers\Admin\SettingsController::class, 'updatePassword'])->name('settings.password');
});

// User Routes
Route::middleware(['auth', 'user'])->prefix('user')->name('user.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    
    // Products
    Route::get('/products', [UserProductController::class, 'index'])->name('products.index');
    Route::get('/products/{product}', [UserProductController::class, 'show'])->name('products.show');
    
    // Wishlist
    Route::get('/wishlist', [UserWishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/add/{product}', [UserWishlistController::class, 'add'])->name('wishlist.add');
    Route::delete('/wishlist/remove/{wishlist}', [UserWishlistController::class, 'remove'])->name('wishlist.remove');
    
    // Orders
    Route::get('/orders', [UserOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/create', [UserOrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [UserOrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [UserOrderController::class, 'show'])->name('orders.show');
    
    // Profile
    Route::get('/profile', [UserProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [UserProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [UserProfileController::class, 'updatePassword'])->name('profile.password');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
