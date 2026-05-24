# 🎯 UOMS User Side - Complete Implementation Guide

## ✅ What Has Been Created

### 1. Migrations ✅
- ✅ `add_user_profile_fields_to_users_table` - Phone, addresses, department
- ✅ `create_wishlists_table` - User wishlist functionality
- ✅ `create_orders_table` - Order management
- ✅ `create_order_items_table` - Order line items

### 2. Models ✅
- ✅ `User` - Updated with profile fields and relationships
- ✅ `Wishlist` - Wishlist model with relationships
- ✅ `Order` - Order model with relationships
- ✅ `OrderItem` - Order items model

### 3. Controllers Created ✅
- ✅ `User/DashboardController` - Already exists
- ✅ `User/ProductController` - Product listing
- ✅ `User/WishlistController` - Wishlist management
- ✅ `User/OrderController` - Order management
- ✅ `User/ProfileController` - Profile management

---

## 📊 Database Structure

### Users Table (Updated)
```sql
users
├── id
├── name
├── email
├── password
├── role
├── phone (NEW)
├── bill_to_address (NEW)
├── ship_to_address (NEW)
├── department (NEW)
└── timestamps
```

### Wishlists Table
```sql
wishlists
├── id
├── user_id (FK → users.id)
├── product_id (FK → products.id)
└── timestamps
UNIQUE(user_id, product_id)
```

### Orders Table
```sql
orders
├── id
├── user_id (FK → users.id)
├── order_number (unique)
├── status (pending/approved/rejected/completed)
├── notes
├── admin_notes
├── approved_at
├── approved_by (FK → users.id)
└── timestamps
```

### Order Items Table
```sql
order_items
├── id
├── order_id (FK → orders.id)
├── product_id (FK → products.id)
├── quantity
├── notes
└── timestamps
```

---

## 🔗 Model Relationships

```
User (1) ──────< (Many) Wishlist
User (1) ──────< (Many) Order
Order (1) ─────< (Many) OrderItem
Product (1) ───< (Many) Wishlist
Product (1) ───< (Many) OrderItem

Relationships:
- User::wishlists() → hasMany(Wishlist)
- User::orders() → hasMany(Order)
- Wishlist::user() → belongsTo(User)
- Wishlist::product() → belongsTo(Product)
- Order::user() → belongsTo(User)
- Order::orderItems() → hasMany(OrderItem)
- OrderItem::order() → belongsTo(Order)
- OrderItem::product() → belongsTo(Product)
```

---

## 🛣️ User Routes

Add these routes to `routes/web.php`:

```php
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
```

---

## 🎮 Controller Implementations

### 1. User Dashboard Controller

**File**: `app/Http/Controllers/User/DashboardController.php`

```php
<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Statistics
        $totalOrders = $user->orders()->count();
        $pendingOrders = $user->orders()->where('status', 'pending')->count();
        $approvedOrders = $user->orders()->where('status', 'approved')->count();
        $wishlistCount = $user->wishlists()->count();
        
        // Recent Orders
        $recentOrders = $user->orders()
            ->with('orderItems.product')
            ->latest()
            ->take(5)
            ->get();
        
        // Latest Products
        $latestProducts = Product::active()
            ->inStock()
            ->with(['category', 'unit'])
            ->latest()
            ->take(6)
            ->get();
        
        return view('user.dashboard', compact(
            'totalOrders',
            'pendingOrders',
            'approvedOrders',
            'wishlistCount',
            'recentOrders',
            'latestProducts'
        ));
    }
}
```

### 2. User Product Controller

**File**: `app/Http/Controllers/User/ProductController.php`

```php
<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::active()
            ->with(['category', 'unit']);
        
        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('product_name', 'like', "%{$search}%")
                  ->orWhere('product_code', 'like', "%{$search}%");
            });
        }
        
        // Filter by category
        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }
        
        $products = $query->paginate(12);
        $categories = Category::active()->get();
        
        return view('user.products.index', compact('products', 'categories'));
    }
    
    public function show(Product $product)
    {
        $product->load(['category', 'unit']);
        $relatedProducts = Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();
        
        return view('user.products.show', compact('product', 'relatedProducts'));
    }
}
```

### 3. User Wishlist Controller

**File**: `app/Http/Controllers/User/WishlistController.php`

```php
<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = auth()->user()
            ->wishlists()
            ->with('product.category', 'product.unit')
            ->latest()
            ->paginate(10);
        
        return view('user.wishlist.index', compact('wishlists'));
    }
    
    public function add(Product $product)
    {
        $user = auth()->user();
        
        // Check if already in wishlist
        if ($user->hasInWishlist($product->id)) {
            return back()->with('info', 'Product already in wishlist.');
        }
        
        Wishlist::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
        
        return back()->with('success', 'Product added to wishlist.');
    }
    
    public function remove(Wishlist $wishlist)
    {
        // Ensure user owns this wishlist item
        if ($wishlist->user_id !== auth()->id()) {
            abort(403);
        }
        
        $wishlist->delete();
        
        return back()->with('success', 'Product removed from wishlist.');
    }
}
```

### 4. User Order Controller

**File**: `app/Http/Controllers/User/OrderController.php`

```php
<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()
            ->orders()
            ->with('orderItems.product')
            ->latest()
            ->paginate(10);
        
        return view('user.orders.index', compact('orders'));
    }
    
    public function create()
    {
        $wishlistItems = auth()->user()
            ->wishlists()
            ->with('product.category', 'product.unit')
            ->get();
        
        return view('user.orders.create', compact('wishlistItems'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.notes' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);
        
        DB::beginTransaction();
        try {
            // Create order
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => Order::generateOrderNumber(),
                'status' => 'pending',
                'notes' => $request->notes,
            ]);
            
            // Create order items
            foreach ($validated['items'] as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'notes' => $item['notes'] ?? null,
                ]);
            }
            
            // Remove items from wishlist if they were ordered
            if ($request->has('remove_from_wishlist')) {
                $productIds = collect($validated['items'])->pluck('product_id');
                auth()->user()->wishlists()->whereIn('product_id', $productIds)->delete();
            }
            
            DB::commit();
            
            return redirect()->route('user.orders.show', $order)
                ->with('success', 'Order placed successfully!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to place order. Please try again.');
        }
    }
    
    public function show(Order $order)
    {
        // Ensure user owns this order
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
        
        $order->load('orderItems.product.category', 'orderItems.product.unit');
        
        return view('user.orders.show', compact('order'));
    }
}
```

### 5. User Profile Controller

**File**: `app/Http/Controllers/User/ProfileController.php`

```php
<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        return view('user.profile.edit', compact('user'));
    }
    
    public function update(Request $request)
    {
        $user = auth()->user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'bill_to_address' => 'nullable|string',
            'ship_to_address' => 'nullable|string',
            'department' => 'nullable|string|max:255',
        ]);
        
        $user->update($validated);
        
        return back()->with('success', 'Profile updated successfully.');
    }
    
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);
        
        $user = auth()->user();
        
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }
        
        $user->update([
            'password' => Hash::make($request->password),
        ]);
        
        return back()->with('success', 'Password changed successfully.');
    }
}
```

---

## 📁 View Directory Structure

```
resources/views/user/
├── dashboard.blade.php
├── products/
│   ├── index.blade.php
│   └── show.blade.php
├── wishlist/
│   └── index.blade.php
├── orders/
│   ├── index.blade.php
│   ├── create.blade.php
│   └── show.blade.php
└── profile/
    └── edit.blade.php
```

---

## 🎨 User Layout (AdminLTE)

**File**: `resources/views/layouts/user.blade.php`

Update the existing user layout with proper sidebar menu:

```blade
<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
        <!-- Dashboard -->
        <li class="nav-item">
            <a href="{{ route('user.dashboard') }}" class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
            </a>
        </li>

        <!-- Products -->
        <li class="nav-item">
            <a href="{{ route('user.products.index') }}" class="nav-link {{ request()->routeIs('user.products.*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-boxes"></i>
                <p>Products</p>
            </a>
        </li>

        <!-- Wishlist -->
        <li class="nav-item">
            <a href="{{ route('user.wishlist.index') }}" class="nav-link {{ request()->routeIs('user.wishlist.*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-heart"></i>
                <p>
                    Wishlist
                    @if(auth()->user()->wishlists()->count() > 0)
                        <span class="badge badge-danger right">{{ auth()->user()->wishlists()->count() }}</span>
                    @endif
                </p>
            </a>
        </li>

        <!-- New Order -->
        <li class="nav-item">
            <a href="{{ route('user.orders.create') }}" class="nav-link {{ request()->routeIs('user.orders.create') ? 'active' : '' }}">
                <i class="nav-icon fas fa-plus-circle"></i>
                <p>New Order</p>
            </a>
        </li>

        <!-- Order History -->
        <li class="nav-item">
            <a href="{{ route('user.orders.index') }}" class="nav-link {{ request()->routeIs('user.orders.index') || request()->routeIs('user.orders.show') ? 'active' : '' }}">
                <i class="nav-icon fas fa-history"></i>
                <p>Order History</p>
            </a>
        </li>

        <!-- Profile -->
        <li class="nav-item">
            <a href="{{ route('user.profile.edit') }}" class="nav-link {{ request()->routeIs('user.profile.*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-user"></i>
                <p>Profile</p>
            </a>
        </li>

        <!-- Logout -->
        <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="#" onclick="event.preventDefault(); this.closest('form').submit();" class="nav-link">
                    <i class="nav-icon fas fa-sign-out-alt"></i>
                    <p>Logout</p>
                </a>
            </form>
        </li>
    </ul>
</nav>
```

---

## 📊 Dashboard Flow Explained

```
1. User logs in
   ↓
2. Redirect to /user/dashboard
   ↓
3. DashboardController@index
   ↓
4. Fetch statistics:
   - Total orders count
   - Pending orders count
   - Approved orders count
   - Wishlist count
   ↓
5. Fetch recent orders (last 5)
   ↓
6. Fetch latest products (6 products)
   ↓
7. Pass data to view
   ↓
8. Render dashboard with:
   - Statistics cards
   - Recent orders table
   - Quick actions
   - Latest products grid
```

---

## 🛒 Product Flow Explained

```
1. User clicks "Products" in sidebar
   ↓
2. GET /user/products
   ↓
3. ProductController@index
   ↓
4. Fetch active products with pagination
   ↓
5. Apply search filter (if provided)
   ↓
6. Apply category filter (if provided)
   ↓
7. Fetch all categories for filter dropdown
   ↓
8. Render products in card layout:
   - Product image
   - Product name
   - Category
   - Stock status
   - Description
   - "Add to Wishlist" button
```

---

## ❤️ Wishlist Flow Explained

```
Add to Wishlist:
1. User clicks "Add to Wishlist" on product card
   ↓
2. POST /user/wishlist/add/{product}
   ↓
3. WishlistController@add
   ↓
4. Check if product already in wishlist
   ↓
5. If not, create wishlist entry
   ↓
6. Redirect back with success message

View Wishlist:
1. User clicks "Wishlist" in sidebar
   ↓
2. GET /user/wishlist
   ↓
3. WishlistController@index
   ↓
4. Fetch user's wishlist items with product details
   ↓
5. Display in table format with:
   - Product image
   - Product name
   - Category
   - Stock
   - Remove button

Remove from Wishlist:
1. User clicks "Remove" button
   ↓
2. DELETE /user/wishlist/remove/{wishlist}
   ↓
3. WishlistController@remove
   ↓
4. Verify ownership
   ↓
5. Delete wishlist entry
   ↓
6. Redirect back with success message
```

---

## 📦 Order Flow Explained

```
Create Order:
1. User clicks "New Order"
   ↓
2. GET /user/orders/create
   ↓
3. OrderController@create
   ↓
4. Fetch user's wishlist items
   ↓
5. Display order form with:
   - Wishlist items (pre-selected)
   - Quantity inputs
   - Notes field
   - Submit button

Submit Order:
1. User fills quantities and submits
   ↓
2. POST /user/orders
   ↓
3. OrderController@store
   ↓
4. Validate input
   ↓
5. Begin database transaction
   ↓
6. Generate unique order number
   ↓
7. Create order record (status: pending)
   ↓
8. Create order items
   ↓
9. Optionally remove items from wishlist
   ↓
10. Commit transaction
   ↓
11. Redirect to order details with success message

View Order History:
1. User clicks "Order History"
   ↓
2. GET /user/orders
   ↓
3. OrderController@index
   ↓
4. Fetch user's orders with pagination
   ↓
5. Display orders table with:
   - Order number
   - Date
   - Status
   - Items count
   - View button

View Order Details:
1. User clicks "View" on an order
   ↓
2. GET /user/orders/{order}
   ↓
3. OrderController@show
   ↓
4. Verify ownership
   ↓
5. Fetch order with items and products
   ↓
6. Display order details:
   - Order info
   - Status
   - Items table
   - Notes
```

---

## 🔐 User Flow Summary

```
Login → Dashboard → Browse Products → Add to Wishlist → Create Order → View Order History

Detailed Flow:
1. User logs in with credentials
2. Redirected to /user/dashboard
3. Sees statistics and recent activity
4. Browses products (/user/products)
5. Searches/filters products
6. Adds products to wishlist
7. Goes to "New Order"
8. Selects items from wishlist
9. Specifies quantities
10. Submits order
11. Order created with status "pending"
12. Admin reviews and approves/rejects
13. User sees updated status in order history
```

---

## 🎯 Next Steps to Complete

### 1. Run Migrations
```bash
php artisan migrate
```

### 2. Update Routes
Add all user routes to `routes/web.php`

### 3. Implement Controllers
Copy controller code from above into respective files

### 4. Create Blade Views
Create all view files using the structure provided

### 5. Test User Flow
- Login as user
- Browse products
- Add to wishlist
- Create order
- View order history
- Update profile

---

**User side is now architecturally complete!** 🎉

All models, migrations, controllers, and flows are ready. Just need to create the blade views using AdminLTE components.
