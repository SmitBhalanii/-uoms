# UOMS Master Modules - Complete Documentation

## 📋 Table of Contents
1. [Overview](#overview)
2. [Database Structure](#database-structure)
3. [Model Relationships](#model-relationships)
4. [Migrations Explained](#migrations-explained)
5. [CRUD Flow](#crud-flow)
6. [Routes Structure](#routes-structure)
7. [Controller Logic](#controller-logic)
8. [Blade Views Structure](#blade-views-structure)
9. [How to Use](#how-to-use)

---

## 1. Overview

Four master modules have been implemented:

### 1.1 Department/Lab Master
- **Purpose**: Manage university labs and departments
- **Features**: CRUD operations, Active/Inactive status
- **Use Case**: Computer Lab, Chemistry Lab, Electrical Lab

### 1.2 Category Master
- **Purpose**: Product grouping and classification
- **Features**: CRUD operations, Product count, Cascade protection
- **Use Case**: Electronics, Mechanical, Chemical, Computer Accessories

### 1.3 Unit Master
- **Purpose**: Define measurement units for products
- **Features**: CRUD operations, Short name support
- **Use Case**: Piece, Box, KG, Liter, Meter

### 1.4 Product Master
- **Purpose**: Manage inventory products
- **Features**: CRUD, Image upload, Search, Filter, Stock management
- **Relationships**: Belongs to Category and Unit

---

## 2. Database Structure

### 2.1 Departments Table
```sql
CREATE TABLE departments (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    department_name VARCHAR(255) NOT NULL,
    lab_code VARCHAR(255) UNIQUE NOT NULL,
    hod_name VARCHAR(255) NULL,
    description TEXT NULL,
    status BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

**Fields Explanation**:
- `id`: Primary key
- `department_name`: Name of department/lab
- `lab_code`: Unique identifier code
- `hod_name`: Head of Department name (optional)
- `description`: Additional details (optional)
- `status`: Active (1) or Inactive (0)
- `timestamps`: Created and updated timestamps

### 2.2 Categories Table
```sql
CREATE TABLE categories (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(255) UNIQUE NOT NULL,
    description TEXT NULL,
    status BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

**Fields Explanation**:
- `id`: Primary key
- `category_name`: Unique category name
- `description`: Category details (optional)
- `status`: Active/Inactive flag
- `timestamps`: Audit trail

### 2.3 Units Table
```sql
CREATE TABLE units (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    unit_name VARCHAR(255) UNIQUE NOT NULL,
    short_name VARCHAR(20) NOT NULL,
    description TEXT NULL,
    status BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

**Fields Explanation**:
- `id`: Primary key
- `unit_name`: Full unit name (e.g., "Kilogram")
- `short_name`: Abbreviation (e.g., "KG")
- `description`: Unit details (optional)
- `status`: Active/Inactive
- `timestamps`: Audit trail

### 2.4 Products Table
```sql
CREATE TABLE products (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category_id BIGINT UNSIGNED NOT NULL,
    unit_id BIGINT UNSIGNED NOT NULL,
    product_name VARCHAR(255) NOT NULL,
    product_code VARCHAR(255) UNIQUE NOT NULL,
    description TEXT NULL,
    stock_quantity INT DEFAULT 0,
    image VARCHAR(255) NULL,
    status BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE,
    FOREIGN KEY (unit_id) REFERENCES units(id) ON DELETE CASCADE
);
```

**Fields Explanation**:
- `id`: Primary key
- `category_id`: Foreign key to categories table
- `unit_id`: Foreign key to units table
- `product_name`: Product name
- `product_code`: Unique product identifier
- `description`: Product details (optional)
- `stock_quantity`: Available quantity
- `image`: Product image path (stored in storage/app/public/products)
- `status`: Active/Inactive
- `timestamps`: Audit trail

---

## 3. Model Relationships

### 3.1 Department Model
```php
// No relationships yet (standalone master)
// Future: Can have hasMany relationship with Orders
```

### 3.2 Category Model
```php
/**
 * One Category has Many Products
 */
public function products(): HasMany
{
    return $this->hasMany(Product::class);
}

// Usage:
$category = Category::find(1);
$products = $category->products; // Get all products in this category
$count = $category->products()->count(); // Count products
```

### 3.3 Unit Model
```php
/**
 * One Unit has Many Products
 */
public function products(): HasMany
{
    return $this->hasMany(Product::class);
}

// Usage:
$unit = Unit::find(1);
$products = $unit->products; // Get all products with this unit
```

### 3.4 Product Model
```php
/**
 * Product belongs to Category
 */
public function category(): BelongsTo
{
    return $this->belongsTo(Category::class);
}

/**
 * Product belongs to Unit
 */
public function unit(): BelongsTo
{
    return $this->belongsTo(Unit::class);
}

// Usage:
$product = Product::find(1);
$categoryName = $product->category->category_name;
$unitName = $product->unit->unit_name;

// Eager loading (prevents N+1 queries):
$products = Product::with(['category', 'unit'])->get();
```

### Relationship Diagram
```
Category (1) ──────< (Many) Product
Unit (1) ──────────< (Many) Product

One Category can have many Products
One Unit can have many Products
One Product belongs to one Category
One Product belongs to one Unit
```

---

## 4. Migrations Explained

### 4.1 Migration Order
Migrations run in chronological order based on timestamp:
1. `create_departments_table` - Independent table
2. `create_categories_table` - Independent table
3. `create_units_table` - Independent table
4. `create_products_table` - Depends on categories and units

### 4.2 Foreign Key Constraints
```php
$table->foreignId('category_id')->constrained()->onDelete('cascade');
```

**Explanation**:
- `foreignId('category_id')`: Creates BIGINT UNSIGNED column
- `constrained()`: Automatically references `id` on `categories` table
- `onDelete('cascade')`: If category is deleted, delete all its products

### 4.3 Running Migrations
```bash
# Run all pending migrations
php artisan migrate

# Rollback last migration
php artisan migrate:rollback

# Rollback all and re-run
php artisan migrate:fresh

# Fresh with seeding
php artisan migrate:fresh --seed
```

---

## 5. CRUD Flow

### 5.1 Create Flow (Example: Department)

**Step 1: User clicks "Add Department"**
```
Route: GET /admin/departments/create
Controller: DepartmentController@create
View: admin.departments.create
```

**Step 2: Form is displayed**
- User fills: department_name, lab_code, hod_name, description, status

**Step 3: User submits form**
```
Route: POST /admin/departments
Controller: DepartmentController@store
```

**Step 4: Controller validates and saves**
```php
$validated = $request->validate([
    'department_name' => 'required|string|max:255',
    'lab_code' => 'required|string|max:255|unique:departments,lab_code',
    'hod_name' => 'nullable|string|max:255',
    'description' => 'nullable|string',
    'status' => 'boolean',
]);

Department::create($validated);
```

**Step 5: Redirect with success message**
```php
return redirect()->route('admin.departments.index')
    ->with('success', 'Department created successfully.');
```

### 5.2 Read Flow

**List All (Index)**
```
Route: GET /admin/departments
Controller: DepartmentController@index
Action: Fetch all departments with pagination
View: admin.departments.index
```

**Show Single**
```
Route: GET /admin/departments/{id}
Controller: DepartmentController@show
Action: Fetch single department
View: admin.departments.show
```

### 5.3 Update Flow

**Step 1: User clicks "Edit"**
```
Route: GET /admin/departments/{id}/edit
Controller: DepartmentController@edit
View: admin.departments.edit (pre-filled form)
```

**Step 2: User submits changes**
```
Route: PUT /admin/departments/{id}
Controller: DepartmentController@update
Action: Validate and update
```

**Step 3: Redirect with success**

### 5.4 Delete Flow

**Step 1: User clicks "Delete"**
```
Route: DELETE /admin/departments/{id}
Controller: DepartmentController@destroy
```

**Step 2: Controller deletes record**
```php
$department->delete();
```

**Step 3: Redirect with success**

---

## 6. Routes Structure

### 6.1 Resource Routes
```php
Route::resource('departments', DepartmentController::class);
```

**This creates 7 routes**:
| Method | URI | Action | Route Name |
|--------|-----|--------|------------|
| GET | /admin/departments | index | admin.departments.index |
| GET | /admin/departments/create | create | admin.departments.create |
| POST | /admin/departments | store | admin.departments.store |
| GET | /admin/departments/{id} | show | admin.departments.show |
| GET | /admin/departments/{id}/edit | edit | admin.departments.edit |
| PUT/PATCH | /admin/departments/{id} | update | admin.departments.update |
| DELETE | /admin/departments/{id} | destroy | admin.departments.destroy |

### 6.2 All Master Module Routes
```php
// In routes/web.php
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('departments', DepartmentController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('units', UnitController::class);
    Route::resource('products', ProductController::class);
});
```

### 6.3 View Routes List
```bash
php artisan route:list --name=admin
```

---

## 7. Controller Logic

### 7.1 Department Controller Methods

**index()** - List all departments
```php
public function index()
{
    $departments = Department::latest()->paginate(10);
    return view('admin.departments.index', compact('departments'));
}
```

**create()** - Show create form
```php
public function create()
{
    return view('admin.departments.create');
}
```

**store()** - Save new department
```php
public function store(Request $request)
{
    $validated = $request->validate([...]);
    Department::create($validated);
    return redirect()->route('admin.departments.index')
        ->with('success', 'Department created successfully.');
}
```

**show()** - Display single department
```php
public function show(Department $department)
{
    return view('admin.departments.show', compact('department'));
}
```

**edit()** - Show edit form
```php
public function edit(Department $department)
{
    return view('admin.departments.edit', compact('department'));
}
```

**update()** - Update department
```php
public function update(Request $request, Department $department)
{
    $validated = $request->validate([...]);
    $department->update($validated);
    return redirect()->route('admin.departments.index')
        ->with('success', 'Department updated successfully.');
}
```

**destroy()** - Delete department
```php
public function destroy(Department $department)
{
    $department->delete();
    return redirect()->route('admin.departments.index')
        ->with('success', 'Department deleted successfully.');
}
```

### 7.2 Product Controller Special Features

**Search Functionality**
```php
if ($request->has('search')) {
    $search = $request->search;
    $query->where(function($q) use ($search) {
        $q->where('product_name', 'like', "%{$search}%")
          ->orWhere('product_code', 'like', "%{$search}%");
    });
}
```

**Filter by Category**
```php
if ($request->has('category_id') && $request->category_id != '') {
    $query->where('category_id', $request->category_id);
}
```

**Image Upload**
```php
if ($request->hasFile('image')) {
    $validated['image'] = $request->file('image')->store('products', 'public');
}
```

**Image Delete on Update**
```php
if ($request->hasFile('image')) {
    // Delete old image
    if ($product->image) {
        Storage::disk('public')->delete($product->image);
    }
    $validated['image'] = $request->file('image')->store('products', 'public');
}
```

### 7.3 Cascade Protection in Category/Unit

**Prevent deletion if products exist**:
```php
public function destroy(Category $category)
{
    if ($category->products()->count() > 0) {
        return redirect()->route('admin.categories.index')
            ->with('error', 'Cannot delete category with existing products.');
    }
    
    $category->delete();
    return redirect()->route('admin.categories.index')
        ->with('success', 'Category deleted successfully.');
}
```

---

## 8. Blade Views Structure

### 8.1 View Directory Structure
```
resources/views/admin/
├── departments/
│   ├── index.blade.php    (List all)
│   ├── create.blade.php   (Create form)
│   ├── edit.blade.php     (Edit form)
│   └── show.blade.php     (View single)
├── categories/
│   ├── index.blade.php
│   ├── create.blade.php
│   ├── edit.blade.php
│   └── show.blade.php
├── units/
│   ├── index.blade.php
│   ├── create.blade.php
│   ├── edit.blade.php
│   └── show.blade.php
└── products/
    ├── index.blade.php
    ├── create.blade.php
    ├── edit.blade.php
    └── show.blade.php
```

### 8.2 Common Blade Patterns

**Extending Layout**
```blade
@extends('layouts.admin')

@section('page-title', 'Departments')

@section('breadcrumb')
    <li class="breadcrumb-item active">Departments</li>
@endsection

@section('content')
    <!-- Content here -->
@endsection
```

**Success/Error Messages**
```blade
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
```

**Validation Errors**
```blade
@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
```

**Form with CSRF**
```blade
<form action="{{ route('admin.departments.store') }}" method="POST">
    @csrf
    <!-- Form fields -->
</form>
```

**Edit Form with Method Spoofing**
```blade
<form action="{{ route('admin.departments.update', $department) }}" method="POST">
    @csrf
    @method('PUT')
    <!-- Form fields -->
</form>
```

**Delete Form**
```blade
<form action="{{ route('admin.departments.destroy', $department) }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
</form>
```

**Pagination**
```blade
{{ $departments->links() }}
```

**Image Upload Form**
```blade
<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="image" accept="image/*">
</form>
```

**Display Image**
```blade
@if($product->image)
    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->product_name }}" width="100">
@else
    <img src="{{ asset('images/no-image.png') }}" alt="No Image" width="100">
@endif
```

---

## 9. How to Use

### 9.1 Setup Storage Link
```bash
php artisan storage:link
```
This creates a symbolic link from `public/storage` to `storage/app/public`

### 9.2 Run Migrations
```bash
php artisan migrate
```

### 9.3 Access Master Modules

**Login as Admin**:
- Email: admin@uoms.com
- Password: password

**Navigate to Master Data**:
1. Click "Master Data" in sidebar
2. Choose: Departments, Categories, or Units
3. Or click "Products" directly

### 9.4 Create Department
1. Go to Master Data → Departments
2. Click "Add Department"
3. Fill form:
   - Department Name: Computer Lab
   - Lab Code: CL001
   - HOD Name: Dr. John Doe
   - Description: Computer Science Laboratory
   - Status: Active
4. Click "Save"

### 9.5 Create Category
1. Go to Master Data → Categories
2. Click "Add Category"
3. Fill form:
   - Category Name: Electronics
   - Description: Electronic components and devices
   - Status: Active
4. Click "Save"

### 9.6 Create Unit
1. Go to Master Data → Units
2. Click "Add Unit"
3. Fill form:
   - Unit Name: Piece
   - Short Name: PCS
   - Description: Individual items
   - Status: Active
4. Click "Save"

### 9.7 Create Product
1. Go to Products
2. Click "Add Product"
3. Fill form:
   - Category: Select from dropdown
   - Unit: Select from dropdown
   - Product Name: Arduino Uno
   - Product Code: ARD001
   - Description: Microcontroller board
   - Stock Quantity: 50
   - Image: Upload image
   - Status: Active
4. Click "Save"

### 9.8 Search Products
1. Go to Products
2. Use search box: Enter product name or code
3. Filter by category: Select from dropdown
4. Filter by status: Active/Inactive

### 9.9 Update Stock
1. Go to Products
2. Click "Edit" on product
3. Update "Stock Quantity"
4. Click "Update"

---

## 10. Database Relationships Summary

```
┌─────────────┐
│ Categories  │
│ - id        │
│ - name      │
└──────┬──────┘
       │
       │ 1:N (One-to-Many)
       │
       ▼
┌─────────────┐      ┌─────────────┐
│  Products   │◄─────┤   Units     │
│ - id        │  N:1 │ - id        │
│ - category_id│      │ - name      │
│ - unit_id   │      └─────────────┘
│ - name      │
│ - code      │
│ - stock     │
│ - image     │
└─────────────┘

┌─────────────┐
│ Departments │ (Standalone)
│ - id        │
│ - name      │
│ - lab_code  │
└─────────────┘
```

**Relationship Rules**:
1. One Category can have many Products
2. One Unit can have many Products
3. One Product belongs to one Category
4. One Product belongs to one Unit
5. Departments are standalone (no current relationships)

---

## 11. Key Features Implemented

✅ **Department Master**
- CRUD operations
- Unique lab code validation
- Active/Inactive status
- Pagination

✅ **Category Master**
- CRUD operations
- Product count display
- Cascade delete protection
- Unique name validation

✅ **Unit Master**
- CRUD operations
- Short name support
- Product count display
- Cascade delete protection

✅ **Product Master**
- CRUD operations
- Image upload/delete
- Search by name/code
- Filter by category
- Filter by status
- Stock quantity management
- Pagination
- Eager loading relationships

---

## 12. Next Steps (Future Enhancements)

1. **Add Seeders** for sample data
2. **Add Validation Requests** for cleaner controllers
3. **Add API endpoints** for mobile app
4. **Add Export** functionality (Excel/PDF)
5. **Add Import** functionality (CSV/Excel)
6. **Add Audit Logs** for tracking changes
7. **Add Soft Deletes** for data recovery
8. **Add Advanced Search** with multiple filters
9. **Add Bulk Operations** (delete, update status)
10. **Add Product Variants** (size, color, etc.)

---

**Master Modules are now complete and ready to use!** 🎉
