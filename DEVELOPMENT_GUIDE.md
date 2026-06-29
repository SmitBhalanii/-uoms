# Development Guide - UOMS

**Complete technical documentation for developers**

---

## 📋 Table of Contents

1. [System Architecture](#system-architecture)
2. [UI Modernization](#ui-modernization)
3. [Features Implementation](#features-implementation)
4. [Git Workflow](#git-workflow)
5. [Testing](#testing)

---

## 🏗️ System Architecture

### Tech Stack
- **Backend**: Laravel 12.x (PHP 8.2+)
- **Frontend**: Blade Templates, Bootstrap 5, AdminLTE 3.2
- **Database**: SQLite (Development), MySQL (Production ready)
- **Authentication**: Laravel Breeze
- **Email**: Laravel Mail with queue support

### Project Structure
```
uoms/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/          # Admin panel controllers
│   │   └── User/           # Lab manager controllers
│   ├── Models/             # Eloquent models
│   └── Mail/               # Email templates
├── resources/
│   └── views/
│       ├── admin/          # Admin views
│       ├── user/           # User views
│       ├── auth/           # Login/register
│       └── layouts/        # Master layouts
├── routes/
│   └── web.php            # All route definitions
└── database/
    ├── migrations/        # Database schema
    └── seeders/          # Sample data
```

### Database Schema

**Key Tables**:
- `users` - Admin and Lab Manager accounts
- `products` - Product catalog with stock
- `categories` - Product categories
- `brands` - Product brands
- `units` - Measurement units
- `departments` - University departments
- `orders` - Order headers
- `order_items` - Order line items
- `sessions` - User sessions

**Relationships**:
- User → Orders (one-to-many)
- Order → OrderItems (one-to-many)
- Product → Category (many-to-one)
- Product → Brand (many-to-one)
- Product → Unit (many-to-one)

---

## 🎨 UI Modernization

### Phase 1: Bug Fixes (Completed)
**Pagination Arrow Bug**
- **Problem**: Giant arrows blocking product pages
- **Solution**: CSS overrides in both layouts
- **Files**: `layouts/admin.blade.php`, `layouts/user.blade.php`

**Logo Display**
- **Problem**: Placeholder AdminLTE logo
- **Solution**: Custom gradient box with university icon
- **Implementation**: 40x40px gradient (#667eea → #764ba2)

### Phase 2: Modern Login (Completed)
**Features**:
- Split-screen layout (branding left, form right)
- Animated gradient background
- Floating particles (6 animated elements)
- Modern form inputs with icons
- Smooth animations (countup, lift, slide)
- Fully responsive design

**File**: `resources/views/auth/login.blade.php` (~350 lines)

### Phase 3: Logo Modernization (Completed)
**Custom Gradient Logo**:
```html
<div class="brand-image elevation-3">
    <i class="fas fa-university"></i>
</div>
```
- CSS: Gradient background with 8px border-radius
- Icon: Font Awesome university icon in white
- Consistent across admin and user sides

### Phase 4: Dashboard Modernization (Completed)

**Admin Dashboard**:
- 9 gradient stat cards (order statuses)
- 3 system stat cards (users, departments, products)
- Modern table with gradient header
- User avatars in order table
- Gradient badges for order statuses
- Modern action buttons

**User Dashboard**:
- 4 gradient stat cards (orders, pending, approved, cart)
- Recent orders table
- Latest products grid with hover effects
- Gradient user info card
- Quick action buttons
- Empty state designs

**Design System**:
```css
/* Gradients */
--gradient-info: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
--gradient-warning: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
--gradient-success: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
--gradient-primary: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);

/* Spacing */
--card-padding: 24px;
--card-radius: 16px;
--icon-size: 64px;

/* Typography */
--stat-value: 36px / 800 weight;
--stat-label: 14px / 600 weight uppercase;
--card-title: 18px / 700 weight;
```

---

## 🔧 Features Implementation

### Cart System
**Location**: `app/Http/Controllers/User/CartController.php`

**Methods**:
- `index()` - Display cart items
- `add(Product $product)` - Add product to cart
- `update(Request $request, Product $product)` - Update quantity
- `remove(Product $product)` - Remove from cart
- `clear()` - Empty cart

**Session Storage**:
```php
// Structure: ['product_id' => quantity]
session()->get('cart', []);
```

**Validations**:
- Product must be active
- Quantity must be > 0
- Cannot exceed available stock
- Cart cannot be empty when placing order

### Order System
**Workflow**:
1. User adds products to cart
2. User places order from cart
3. Admin receives email notification
4. Admin processes order (approve/reject)
5. User receives status update email
6. Order marked as completed when fulfilled

**Status Flow**:
```
pending → processing → approved → completed
        ↓
      rejected
```

### Email Notifications
**Templates**:
- `OrderPlaced` - Sent to user after order creation
- `OrderPlacedAdmin` - Sent to admin for new orders
- `OrderStatusUpdated` - Sent to user on status change

**Configuration** (`.env`):
```env
ADMIN_EMAIL=admin@example.com
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
```

### Reports System
**Available Reports**:
1. **Low Stock Products** - Products with stock ≤ 10
2. **Monthly Orders Trend** - Line chart of orders
3. **Orders by Status** - Pie chart distribution
4. **Top 10 Products** - Most ordered items
5. **Orders Calendar** - FullCalendar view

**PDF Export**:
- Low stock report can be exported to PDF
- Includes date/time stamp
- Professional formatting

---

## 🔀 Git Workflow

### Branch Strategy

**main** - Production branch with modern gradient UI
- All Phase 1-4 modernization complete
- Latest features and bug fixes
- Production-ready modern design

### Making Changes

**Standard Workflow**:
```bash
# Make your changes
git add .
git commit -m "feat: Description of changes"
git push origin main
```

**Always clear cache after updates**:
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

---

## 🧪 Testing

### Manual Testing Checklist

**Login Flow**:
- [ ] Login with admin credentials
- [ ] Login with user credentials
- [ ] "Remember me" checkbox works
- [ ] Logout and login again
- [ ] Session persists correctly

**Admin Features**:
- [ ] View all orders
- [ ] Update order status
- [ ] Add new product
- [ ] Edit product stock
- [ ] Generate low stock report
- [ ] Export PDF report
- [ ] View order calendar

**User Features**:
- [ ] Browse products
- [ ] Add to cart
- [ ] Update cart quantities
- [ ] Remove from cart
- [ ] Place order
- [ ] View order history
- [ ] Check order status

**UI/UX**:
- [ ] Gradient cards display correctly
- [ ] Hover effects work smoothly
- [ ] Numbers animate on page load
- [ ] Tables hover properly
- [ ] Badges show correct colors
- [ ] Pagination works without giant arrows
- [ ] Logo displays correctly
- [ ] Responsive on mobile

**Email Testing**:
- [ ] Order placed email (user)
- [ ] Order placed email (admin)
- [ ] Status update emails
- [ ] Email templates format correctly

### Performance Testing

**Load Time Goals**:
- Dashboard load: < 2 seconds
- Product list: < 3 seconds
- Cart operations: < 1 second
- Report generation: < 5 seconds

**Optimization Tips**:
- Use query caching for reports
- Eager load relationships
- Optimize images (product photos)
- Use pagination for large lists

---

## 📝 Code Standards

### Naming Conventions
- **Controllers**: `{Model}Controller` (e.g., `ProductController`)
- **Models**: Singular PascalCase (e.g., `Order`, `OrderItem`)
- **Views**: kebab-case (e.g., `user-dashboard.blade.php`)
- **Routes**: kebab-case with dots (e.g., `admin.products.index`)
- **Methods**: camelCase (e.g., `getUserOrders()`)

### Blade Template Structure
```blade
@extends('layouts.admin')

@section('page-title', 'Page Title')

@section('breadcrumb')
    <li class="breadcrumb-item active">Current</li>
@endsection

@push('styles')
    <!-- Page-specific CSS -->
@endpush

@section('content')
    <!-- Page content -->
@endsection

@push('scripts')
    <!-- Page-specific JS -->
@endpush
```

### Controller Pattern
```php
class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category', 'brand')
            ->paginate(12);
            
        return view('admin.products.index', compact('products'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'stock_quantity' => 'required|integer|min:0',
        ]);
        
        Product::create($validated);
        
        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully');
    }
}
```

---

## 🚀 Deployment

### Production Checklist
- [ ] Update `.env` with production values
- [ ] Change `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Configure production database
- [ ] Setup email server (SMTP)
- [ ] Change default passwords
- [ ] Setup SSL certificate
- [ ] Configure session driver (redis recommended)
- [ ] Run migrations on production DB
- [ ] Clear and cache config
- [ ] Setup backup strategy

### Optimization Commands
```bash
# Production optimization
php artisan config:cache
php artisan route:cache
php artisan view:cache
composer install --optimize-autoloader --no-dev
```

---

## 📊 Performance Monitoring

### Key Metrics to Track
- **Page Load Time**: Target < 3 seconds
- **Database Queries**: Minimize N+1 problems
- **Memory Usage**: Monitor for leaks
- **Session Size**: Keep minimal data
- **Email Queue**: Process timely

### Tools
- Laravel Debugbar (development only)
- Laravel Telescope (optional)
- Server logs monitoring
- Database query logging

---

## 🔒 Security Best Practices

1. **Never commit**:
   - `.env` file
   - Database files
   - Vendor directory
   - node_modules

2. **Always**:
   - Use CSRF protection
   - Validate all inputs
   - Sanitize outputs
   - Use prepared statements
   - Hash passwords (automatic with Laravel)

3. **Production**:
   - Disable debug mode
   - Use HTTPS
   - Setup rate limiting
   - Regular security updates
   - Monitor logs for attacks

---

**For installation and usage, see `README.md`**  
**For project history, see `CHANGELOG.md`**
