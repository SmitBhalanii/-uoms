# UOMS - Quick Reference Guide

## 🚀 Quick Start Commands

```bash
# Navigate to project
cd uoms

# Create database
mysql -u root -p
CREATE DATABASE uoms;
exit;

# Run migrations
php artisan migrate

# Seed database
php artisan db:seed

# Start server
php artisan serve

# Visit: http://localhost:8000
```

---

## 🔑 Test Credentials

| Role | Email | Password | Dashboard URL |
|------|-------|----------|---------------|
| Admin | admin@uoms.com | password | /admin/dashboard |
| User | user@uoms.com | password | /user/dashboard |
| User | john@uoms.com | password | /user/dashboard |
| User | jane@uoms.com | password | /user/dashboard |

---

## 📁 Important File Locations

### Controllers
```
app/Http/Controllers/Admin/DashboardController.php
app/Http/Controllers/User/DashboardController.php
app/Http/Controllers/Auth/AuthenticatedSessionController.php
```

### Middleware
```
app/Http/Middleware/AdminMiddleware.php
app/Http/Middleware/UserMiddleware.php
bootstrap/app.php (middleware registration)
```

### Views
```
resources/views/layouts/admin.blade.php
resources/views/layouts/user.blade.php
resources/views/admin/dashboard.blade.php
resources/views/user/dashboard.blade.php
```

### Routes
```
routes/web.php (all web routes)
routes/auth.php (authentication routes)
```

### Models
```
app/Models/User.php
```

### Database
```
database/migrations/2026_05_24_112527_add_role_to_users_table.php
database/seeders/UserSeeder.php
database/seeders/DatabaseSeeder.php
```

---

## 🛣️ Route Quick Reference

### Public Routes
```php
GET  /                    → Welcome page
```

### Authentication Routes
```php
GET  /login               → Login form
POST /login               → Login action
GET  /register            → Register form
POST /register            → Register action
GET  /forgot-password     → Forgot password form
POST /forgot-password     → Send reset link
POST /logout              → Logout
```

### Admin Routes (Middleware: auth, admin)
```php
GET  /admin/dashboard     → Admin dashboard
```

### User Routes (Middleware: auth, user)
```php
GET  /user/dashboard      → User dashboard
```

### Profile Routes (Middleware: auth)
```php
GET    /profile           → Edit profile
PATCH  /profile           → Update profile
DELETE /profile           → Delete account
```

---

## 🎨 Blade Directives Quick Reference

### Layout Inheritance
```blade
@extends('layouts.admin')           {{-- Extend layout --}}
@section('content')                 {{-- Define section --}}
@endsection                         {{-- End section --}}
@yield('content')                   {{-- Output section --}}
```

### Control Structures
```blade
@if($condition)                     {{-- If statement --}}
@elseif($condition)                 {{-- Else if --}}
@else                               {{-- Else --}}
@endif                              {{-- End if --}}

@foreach($items as $item)           {{-- Loop --}}
@endforeach                         {{-- End loop --}}

@auth                               {{-- If authenticated --}}
@endauth                            {{-- End auth --}}

@guest                              {{-- If guest --}}
@endguest                           {{-- End guest --}}
```

### Output
```blade
{{ $variable }}                     {{-- Escaped output --}}
{!! $html !!}                       {{-- Unescaped output --}}
{{ $var ?? 'default' }}             {{-- With default --}}
```

### Assets & URLs
```blade
{{ asset('css/app.css') }}          {{-- Public asset --}}
{{ route('admin.dashboard') }}      {{-- Named route --}}
{{ url('/admin/dashboard') }}       {{-- URL --}}
```

### Forms
```blade
@csrf                               {{-- CSRF token --}}
@method('PUT')                      {{-- Method spoofing --}}
```

### Stacks
```blade
@push('scripts')                    {{-- Push to stack --}}
@endpush                            {{-- End push --}}
@stack('scripts')                   {{-- Output stack --}}
```

---

## 🔧 Artisan Commands Quick Reference

### General
```bash
php artisan serve                   # Start dev server
php artisan list                    # List all commands
php artisan help <command>          # Help for command
```

### Database
```bash
php artisan migrate                 # Run migrations
php artisan migrate:rollback        # Rollback last migration
php artisan migrate:fresh           # Drop all tables and re-run
php artisan migrate:fresh --seed    # Fresh + seed
php artisan db:seed                 # Run seeders
php artisan db:seed --class=UserSeeder  # Run specific seeder
```

### Make Commands
```bash
php artisan make:controller Admin/ProductController
php artisan make:model Product -m   # With migration
php artisan make:migration create_products_table
php artisan make:seeder ProductSeeder
php artisan make:middleware CheckRole
php artisan make:request StoreProductRequest
```

### Cache
```bash
php artisan cache:clear             # Clear cache
php artisan config:clear            # Clear config cache
php artisan route:clear             # Clear route cache
php artisan view:clear              # Clear view cache
```

### Routes
```bash
php artisan route:list              # List all routes
php artisan route:list --name=admin # Filter by name
```

---

## 🔐 Authentication Helper Functions

### In Controllers
```php
// Get authenticated user
$user = Auth::user();
$user = auth()->user();

// Check if authenticated
if (Auth::check()) { }
if (auth()->check()) { }

// Get user ID
$id = Auth::id();
$id = auth()->id();

// Logout
Auth::logout();
auth()->logout();
```

### In Blade Views
```blade
@auth
    <p>Welcome, {{ Auth::user()->name }}</p>
@endauth

@guest
    <a href="{{ route('login') }}">Login</a>
@endguest

{{-- User info --}}
{{ Auth::user()->name }}
{{ Auth::user()->email }}
{{ Auth::user()->role }}
```

---

## 🛡️ Middleware Usage

### Apply to Routes
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
});
```

### Apply to Controllers
```php
class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin')->only(['index', 'show']);
        $this->middleware('admin')->except(['public']);
    }
}
```

---

## 📊 Database Query Quick Reference

### Basic Queries
```php
// Get all
$users = User::all();

// Find by ID
$user = User::find(1);
$user = User::findOrFail(1);  // Throws 404 if not found

// Where clause
$admins = User::where('role', 'admin')->get();
$user = User::where('email', 'admin@uoms.com')->first();

// Create
$user = User::create([
    'name' => 'John',
    'email' => 'john@example.com',
    'password' => Hash::make('password'),
    'role' => 'user',
]);

// Update
$user->update(['name' => 'Jane']);

// Delete
$user->delete();
```

### Advanced Queries
```php
// Count
$count = User::where('role', 'admin')->count();

// Order by
$users = User::orderBy('created_at', 'desc')->get();

// Limit
$users = User::take(10)->get();
$users = User::limit(10)->get();

// Pagination
$users = User::paginate(15);

// Latest/Oldest
$users = User::latest()->get();  // Order by created_at desc
$users = User::oldest()->get();  // Order by created_at asc
```

---

## 🎯 Common Tasks

### Create a New Admin Route
```php
// 1. Add route in routes/web.php
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
});

// 2. Create controller
php artisan make:controller Admin/UserController

// 3. Add method
public function index() {
    $users = User::all();
    return view('admin.users.index', compact('users'));
}

// 4. Create view
resources/views/admin/users/index.blade.php
```

### Create a New User Route
```php
// 1. Add route in routes/web.php
Route::middleware(['auth', 'user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
});

// 2. Create controller
php artisan make:controller User/OrderController

// 3. Add method
public function index() {
    $orders = auth()->user()->orders;
    return view('user.orders.index', compact('orders'));
}

// 4. Create view
resources/views/user/orders/index.blade.php
```

### Add a New Model with Migration
```bash
# Create model with migration
php artisan make:model Product -m

# Edit migration file
database/migrations/xxxx_create_products_table.php

# Run migration
php artisan migrate
```

### Add Sidebar Menu Item
```blade
{{-- In layouts/admin.blade.php or layouts/user.blade.php --}}
<li class="nav-item">
    <a href="{{ route('admin.products.index') }}" 
       class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-boxes"></i>
        <p>Products</p>
    </a>
</li>
```

---

## 🐛 Debugging Tips

### Enable Debug Mode
```env
# .env file
APP_DEBUG=true
APP_ENV=local
```

### View Logs
```bash
# Location
storage/logs/laravel.log

# Tail logs
tail -f storage/logs/laravel.log
```

### Debug in Code
```php
// Dump and die
dd($variable);

// Dump
dump($variable);

// Log
Log::info('User logged in', ['user_id' => $user->id]);
Log::error('Error message', ['error' => $e->getMessage()]);
```

### Common Issues

**403 Forbidden**
```php
// Check user role
dd(auth()->user()->role);

// Clear cache
php artisan cache:clear
php artisan config:clear
```

**Route not found**
```bash
# List all routes
php artisan route:list

# Clear route cache
php artisan route:clear
```

**Database connection error**
```env
# Check .env file
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=uoms
DB_USERNAME=root
DB_PASSWORD=
```

---

## 📚 Useful Links

- **Laravel Docs**: https://laravel.com/docs
- **AdminLTE Docs**: https://adminlte.io/docs
- **Bootstrap Docs**: https://getbootstrap.com/docs
- **Font Awesome Icons**: https://fontawesome.com/icons
- **Laravel Breeze**: https://laravel.com/docs/starter-kits#breeze

---

## 💡 Pro Tips

1. **Always use named routes** instead of hardcoded URLs
   ```blade
   {{-- Good --}}
   <a href="{{ route('admin.dashboard') }}">Dashboard</a>
   
   {{-- Bad --}}
   <a href="/admin/dashboard">Dashboard</a>
   ```

2. **Use route model binding** for cleaner code
   ```php
   // Instead of
   public function show($id) {
       $product = Product::findOrFail($id);
   }
   
   // Use
   public function show(Product $product) {
       // $product is automatically loaded
   }
   ```

3. **Use form requests** for validation
   ```bash
   php artisan make:request StoreProductRequest
   ```

4. **Use resource controllers** for CRUD
   ```php
   Route::resource('products', ProductController::class);
   ```

5. **Use eager loading** to prevent N+1 queries
   ```php
   // Instead of
   $orders = Order::all();
   foreach ($orders as $order) {
       echo $order->user->name;  // N+1 query
   }
   
   // Use
   $orders = Order::with('user')->get();
   ```

---

This quick reference guide provides fast access to commonly used commands, patterns, and solutions for the UOMS project.
