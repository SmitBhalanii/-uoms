# UOMS - System Architecture Documentation

## Table of Contents
1. [Overview](#overview)
2. [Folder Structure](#folder-structure)
3. [Route Flow](#route-flow)
4. [Authentication Flow](#authentication-flow)
5. [Middleware Flow](#middleware-flow)
6. [Dashboard Rendering](#dashboard-rendering)
7. [Database Schema](#database-schema)
8. [Design Patterns](#design-patterns)

---

## 1. Overview

UOMS (University Order Management System) is built using Laravel 12 following clean MVC architecture principles. The system implements role-based access control (RBAC) with two distinct user roles: Admin and Lab Manager (User).

### Key Architectural Decisions
- **Framework**: Laravel 12 (latest stable version)
- **Authentication**: Laravel Breeze (lightweight, Blade-based)
- **UI Framework**: AdminLTE 3.2 + Bootstrap 5
- **Database**: MySQL
- **Template Engine**: Blade
- **Architecture Pattern**: MVC (Model-View-Controller)

---

## 2. Folder Structure

```
uoms/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/                    # Admin-specific controllers
│   │   │   │   └── DashboardController.php
│   │   │   ├── User/                     # User-specific controllers
│   │   │   │   └── DashboardController.php
│   │   │   ├── Auth/                     # Authentication controllers (Breeze)
│   │   │   │   ├── AuthenticatedSessionController.php
│   │   │   │   ├── RegisteredUserController.php
│   │   │   │   └── PasswordResetLinkController.php
│   │   │   └── ProfileController.php
│   │   │
│   │   ├── Middleware/                   # Custom middleware
│   │   │   ├── AdminMiddleware.php       # Protects admin routes
│   │   │   └── UserMiddleware.php        # Protects user routes
│   │   │
│   │   └── Requests/                     # Form requests
│   │       └── Auth/
│   │           └── LoginRequest.php
│   │
│   └── Models/
│       └── User.php                      # User model with role field
│
├── bootstrap/
│   └── app.php                           # Application bootstrap & middleware registration
│
├── config/                               # Configuration files
│   ├── app.php
│   ├── auth.php
│   └── database.php
│
├── database/
│   ├── migrations/
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   └── 2026_05_24_112527_add_role_to_users_table.php
│   │
│   └── seeders/
│       ├── DatabaseSeeder.php
│       └── UserSeeder.php                # Seeds test users
│
├── public/                               # Public assets
│   ├── index.php                         # Entry point
│   └── build/                            # Compiled assets
│
├── resources/
│   ├── views/
│   │   ├── layouts/                      # Reusable layouts
│   │   │   ├── admin.blade.php           # Admin panel layout
│   │   │   ├── user.blade.php            # User panel layout
│   │   │   └── guest.blade.php           # Guest layout (Breeze)
│   │   │
│   │   ├── admin/                        # Admin views
│   │   │   └── dashboard.blade.php
│   │   │
│   │   ├── user/                         # User views
│   │   │   └── dashboard.blade.php
│   │   │
│   │   ├── auth/                         # Authentication views
│   │   │   ├── login.blade.php
│   │   │   ├── register.blade.php
│   │   │   ├── forgot-password.blade.php
│   │   │   └── reset-password.blade.php
│   │   │
│   │   └── profile/                      # Profile views
│   │       └── edit.blade.php
│   │
│   ├── css/
│   └── js/
│
├── routes/
│   ├── web.php                           # Web routes
│   ├── auth.php                          # Authentication routes (Breeze)
│   └── console.php
│
├── storage/                              # Storage for logs, cache, sessions
│   ├── app/
│   ├── framework/
│   └── logs/
│
├── tests/                                # Test files
│   ├── Feature/
│   └── Unit/
│
├── vendor/                               # Composer dependencies
│
├── .env                                  # Environment configuration
├── .env.example
├── artisan                               # Artisan CLI
├── composer.json                         # PHP dependencies
├── package.json                          # Node dependencies
└── vite.config.js                        # Vite configuration
```

### Folder Organization Principles

1. **Controllers are organized by role**:
   - `Admin/` - Admin-specific controllers
   - `User/` - User-specific controllers
   - `Auth/` - Authentication controllers

2. **Views mirror controller structure**:
   - `admin/` - Admin views
   - `user/` - User views
   - `auth/` - Authentication views

3. **Layouts are reusable**:
   - `layouts/admin.blade.php` - For admin pages
   - `layouts/user.blade.php` - For user pages
   - `layouts/guest.blade.php` - For guest pages

4. **Middleware is role-specific**:
   - `AdminMiddleware` - Admin access control
   - `UserMiddleware` - User access control

---

## 3. Route Flow

### Route Organization

Routes are organized using Laravel's route groups with middleware and prefixes:

```php
// routes/web.php

// Public Routes
Route::get('/', function () {
    return view('welcome');
});

// Admin Routes (Prefix: /admin, Middleware: auth, admin)
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');
        // Future admin routes here
    });

// User Routes (Prefix: /user, Middleware: auth, user)
Route::middleware(['auth', 'user'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {
        Route::get('/dashboard', [UserDashboardController::class, 'index'])
            ->name('dashboard');
        // Future user routes here
    });

// Profile Routes (Middleware: auth)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Authentication Routes (from Breeze)
require __DIR__.'/auth.php';
```

### Route Flow Diagram

```
User Request
    ↓
Public Routes (/, /login, /register)
    ↓
Authentication (Breeze)
    ↓
Role Check (Middleware)
    ↓
    ├─→ Admin? → AdminMiddleware → /admin/dashboard
    │
    └─→ User? → UserMiddleware → /user/dashboard
```

### Route Naming Convention

- **Admin routes**: `admin.{action}` (e.g., `admin.dashboard`)
- **User routes**: `user.{action}` (e.g., `user.dashboard`)
- **Auth routes**: `login`, `register`, `logout`, etc.
- **Profile routes**: `profile.edit`, `profile.update`, `profile.destroy`

### RESTful Route Structure (Future Implementation)

For CRUD operations, follow RESTful conventions:

```php
// Example: Products
Route::resource('admin/products', ProductController::class);

// Generates:
// GET    /admin/products           → index()
// GET    /admin/products/create    → create()
// POST   /admin/products           → store()
// GET    /admin/products/{id}      → show()
// GET    /admin/products/{id}/edit → edit()
// PUT    /admin/products/{id}      → update()
// DELETE /admin/products/{id}      → destroy()
```

---

## 4. Authentication Flow

### Registration Flow

```
1. User visits /register
   ↓
2. RegisteredUserController@create displays form
   ↓
3. User submits form
   ↓
4. RegisteredUserController@store validates data
   ↓
5. User created with default role='user'
   ↓
6. User logged in automatically
   ↓
7. Redirect to /user/dashboard (via AuthenticatedSessionController)
```

### Login Flow

```
1. User visits /login
   ↓
2. AuthenticatedSessionController@create displays form
   ↓
3. User submits credentials
   ↓
4. AuthenticatedSessionController@store validates
   ↓
5. LoginRequest authenticates user
   ↓
6. Check user role:
   ├─→ role='admin' → redirect to /admin/dashboard
   └─→ role='user'  → redirect to /user/dashboard
   ↓
7. Session created, user authenticated
```

### Login Controller Logic

```php
// app/Http/Controllers/Auth/AuthenticatedSessionController.php

public function store(LoginRequest $request): RedirectResponse
{
    // Authenticate user
    $request->authenticate();
    
    // Regenerate session (security)
    $request->session()->regenerate();
    
    // Get authenticated user
    $user = Auth::user();
    
    // Role-based redirect
    if ($user->role === 'admin') {
        return redirect()->intended(route('admin.dashboard'));
    }
    
    return redirect()->intended(route('user.dashboard'));
}
```

### Logout Flow

```
1. User clicks logout button
   ↓
2. Form submits POST to /logout
   ↓
3. AuthenticatedSessionController@destroy
   ↓
4. Logout user from 'web' guard
   ↓
5. Invalidate session
   ↓
6. Regenerate CSRF token
   ↓
7. Redirect to /
```

### Password Reset Flow

```
1. User visits /forgot-password
   ↓
2. User enters email
   ↓
3. PasswordResetLinkController sends reset link
   ↓
4. User clicks link in email
   ↓
5. User visits /reset-password/{token}
   ↓
6. User enters new password
   ↓
7. NewPasswordController resets password
   ↓
8. Redirect to /login
```

---

## 5. Middleware Flow

### Middleware Architecture

```
HTTP Request
    ↓
Global Middleware (Laravel default)
    ├─→ TrustProxies
    ├─→ HandleCors
    ├─→ ValidatePostSize
    └─→ TrimStrings
    ↓
Route Middleware
    ├─→ auth (Authenticate)
    ├─→ admin (AdminMiddleware)
    └─→ user (UserMiddleware)
    ↓
Controller Action
    ↓
HTTP Response
```

### AdminMiddleware Logic

```php
// app/Http/Middleware/AdminMiddleware.php

public function handle(Request $request, Closure $next): Response
{
    // Check if user is authenticated AND has admin role
    if (auth()->check() && auth()->user()->role === 'admin') {
        return $next($request);  // Allow access
    }
    
    // Deny access with 403 error
    abort(403, 'Unauthorized access.');
}
```

### UserMiddleware Logic

```php
// app/Http/Middleware/UserMiddleware.php

public function handle(Request $request, Closure $next): Response
{
    // Check if user is authenticated AND has user role
    if (auth()->check() && auth()->user()->role === 'user') {
        return $next($request);  // Allow access
    }
    
    // Deny access with 403 error
    abort(403, 'Unauthorized access.');
}
```

### Middleware Registration

```php
// bootstrap/app.php

->withMiddleware(function (Middleware $middleware): void {
    $middleware->alias([
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
        'user' => \App\Http\Middleware\UserMiddleware::class,
    ]);
})
```

### Middleware Application Examples

```php
// Single middleware
Route::get('/admin/dashboard', [DashboardController::class, 'index'])
    ->middleware('admin');

// Multiple middleware
Route::get('/admin/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'admin']);

// Group middleware
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index']);
    Route::get('/admin/users', [UserController::class, 'index']);
});
```

### Middleware Execution Order

1. **Global Middleware** (always executed)
2. **Route Middleware** (applied to specific routes)
   - `auth` - Checks if user is authenticated
   - `admin` or `user` - Checks user role
3. **Controller** - Executes if all middleware passes

---

## 6. Dashboard Rendering

### Admin Dashboard Flow

```
1. User authenticated as admin
   ↓
2. Request: GET /admin/dashboard
   ↓
3. Middleware: auth → AdminMiddleware
   ↓
4. Controller: Admin\DashboardController@index
   ↓
5. View: admin.dashboard
   ↓
6. Layout: layouts.admin
   ↓
7. Rendered HTML sent to browser
```

### Admin Dashboard Controller

```php
// app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // Future: Fetch statistics, recent orders, etc.
        // $stats = Order::getStatistics();
        // $recentOrders = Order::latest()->take(10)->get();
        
        return view('admin.dashboard');
    }
}
```

### Admin Dashboard View Structure

```blade
{{-- resources/views/admin/dashboard.blade.php --}}

@extends('layouts.admin')

@section('page-title', 'Admin Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
    {{-- Dashboard content here --}}
@endsection
```

### Admin Layout Structure

```blade
{{-- resources/views/layouts/admin.blade.php --}}

<!DOCTYPE html>
<html>
<head>
    {{-- Meta tags, CSS --}}
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        {{-- Navbar --}}
        <nav class="main-header navbar">...</nav>
        
        {{-- Sidebar --}}
        <aside class="main-sidebar">...</aside>
        
        {{-- Content Wrapper --}}
        <div class="content-wrapper">
            {{-- Content Header --}}
            <div class="content-header">
                <h1>@yield('page-title')</h1>
                <ol class="breadcrumb">@yield('breadcrumb')</ol>
            </div>
            
            {{-- Main Content --}}
            <section class="content">
                @yield('content')
            </section>
        </div>
        
        {{-- Footer --}}
        <footer class="main-footer">...</footer>
    </div>
    
    {{-- Scripts --}}
    @stack('scripts')
</body>
</html>
```

### User Dashboard Flow

```
1. User authenticated as lab manager
   ↓
2. Request: GET /user/dashboard
   ↓
3. Middleware: auth → UserMiddleware
   ↓
4. Controller: User\DashboardController@index
   ↓
5. View: user.dashboard
   ↓
6. Layout: layouts.user
   ↓
7. Rendered HTML sent to browser
```

### Blade Template Inheritance

```
layouts/admin.blade.php (Master Layout)
    ↓
    ├─→ @yield('page-title')
    ├─→ @yield('breadcrumb')
    ├─→ @yield('content')
    └─→ @stack('scripts')
    
admin/dashboard.blade.php (Child View)
    ↓
    ├─→ @extends('layouts.admin')
    ├─→ @section('page-title', 'Admin Dashboard')
    ├─→ @section('breadcrumb') ... @endsection
    └─→ @section('content') ... @endsection
```

---

## 7. Database Schema

### Users Table

```sql
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

### User Model

```php
// app/Models/User.php

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    
    // Helper methods (future)
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
    
    public function isUser(): bool
    {
        return $this->role === 'user';
    }
}
```

### Future Tables (Recommended)

```sql
-- Products Table
CREATE TABLE products (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    category_id BIGINT UNSIGNED,
    quantity INT DEFAULT 0,
    unit VARCHAR(50),
    price DECIMAL(10,2),
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- Orders Table
CREATE TABLE orders (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    order_number VARCHAR(50) UNIQUE,
    status ENUM('pending', 'approved', 'rejected', 'completed') DEFAULT 'pending',
    total_amount DECIMAL(10,2),
    notes TEXT,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Order Items Table
CREATE TABLE order_items (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    order_id BIGINT UNSIGNED NOT NULL,
    product_id BIGINT UNSIGNED NOT NULL,
    quantity INT NOT NULL,
    unit_price DECIMAL(10,2),
    subtotal DECIMAL(10,2),
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);
```

---

## 8. Design Patterns

### 1. MVC Pattern

**Model**: Handles data and business logic
```php
class User extends Model {
    // Database interactions
    // Business logic
    // Relationships
}
```

**View**: Handles presentation
```blade
@extends('layouts.admin')
@section('content')
    {{-- HTML presentation --}}
@endsection
```

**Controller**: Handles request/response
```php
class DashboardController extends Controller {
    public function index() {
        // Get data from model
        // Pass to view
        return view('admin.dashboard');
    }
}
```

### 2. Repository Pattern (Future Implementation)

```php
// app/Repositories/OrderRepository.php
class OrderRepository {
    public function getAll() { }
    public function find($id) { }
    public function create(array $data) { }
    public function update($id, array $data) { }
    public function delete($id) { }
}

// Usage in controller
class OrderController extends Controller {
    public function __construct(
        private OrderRepository $orderRepo
    ) {}
    
    public function index() {
        $orders = $this->orderRepo->getAll();
        return view('admin.orders.index', compact('orders'));
    }
}
```

### 3. Service Layer Pattern (Future Implementation)

```php
// app/Services/OrderService.php
class OrderService {
    public function createOrder(array $data) {
        // Complex business logic
        // Multiple model interactions
        // Send notifications
        // Log activities
    }
}
```

### 4. Middleware Pattern

Already implemented for authentication and authorization:
```php
AdminMiddleware → Checks admin role
UserMiddleware → Checks user role
```

### 5. Facade Pattern

Laravel uses facades extensively:
```php
Auth::user()
Route::get()
DB::table()
```

---

## Summary

This architecture provides:

✅ **Clean separation of concerns** (MVC)
✅ **Role-based access control** (RBAC)
✅ **Reusable layouts** (Blade inheritance)
✅ **RESTful routing** (Laravel conventions)
✅ **Secure authentication** (Laravel Breeze)
✅ **Scalable structure** (Organized folders)
✅ **Professional UI** (AdminLTE + Bootstrap)
✅ **Beginner-friendly** (Clear naming, comments)

The system is ready for feature expansion while maintaining clean architecture principles.
