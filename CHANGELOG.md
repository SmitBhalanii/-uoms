# Changelog - UOMS

All notable changes to the University Order Management System.

---

## [1.0.0] - 2026-06-30

### 🎉 Initial Release

#### Added
- Complete university order management system
- Admin and Lab Manager role separation
- Product catalog with categories, brands, and units
- Shopping cart system for lab managers
- Order placement and approval workflow
- Email notifications for orders
- Dashboard analytics with charts
- Low stock monitoring and reports
- Order calendar view
- PDF export for reports
- Two UI branches (modern and classic)

---

## Phase 4 - Dashboard Modernization (2026-06-30)

### ✨ Added
- **Modern gradient stat cards** with 8 unique gradient combinations
- **Animated number counters** with smooth transitions
- **Icon wrappers** with gradient backgrounds and shadows
- **Hover lift effects** on all cards (8px translateY + enhanced shadow)
- **Modern table design** with gradient headers
- **User avatars** in admin order table
- **Gradient badges** for order statuses
- **Modern buttons** with gradient backgrounds and hover effects
- **User info card** with gradient background (user dashboard)
- **Quick action buttons** with gradient styling
- **Empty state designs** for no orders scenario
- **Product cards** with hover animations

### 🎨 Design System Established
- **8 Gradients**: info, warning, primary, success, danger, secondary, dark, teal
- **Spacing**: 24px cards, 16px elements
- **Typography**: 36px stat values, 18px headers, 14px body
- **Shadows**: Layered elevation (2px to 32px)
- **Animations**: 0.3-0.6s smooth transitions
- **Border Radius**: 12-24px for modern look

### 📁 Files Modified
- `resources/views/admin/dashboard.blade.php` (~500 lines CSS + HTML)
- `resources/views/user/dashboard.blade.php` (~550 lines CSS + HTML)

---

## Phase 3 - Logo Modernization (2026-06-30)

### ✨ Added
- Custom gradient logo with Font Awesome university icon
- 40x40px gradient box (#667eea → #764ba2)
- 8px border radius for modern appearance
- Consistent branding across admin and user sides

### 🔧 Changed
- Replaced AdminLTE placeholder logo in admin layout
- Replaced AdminLTE placeholder logo in user layout

### 📁 Files Modified
- `resources/views/layouts/admin.blade.php`
- `resources/views/layouts/user.blade.php`

---

## Phase 2 - Modern Login Page (2026-06-30)

### ✨ Added
- **Split-screen login design** (branding left, form right)
- **Animated gradient background** (purple theme)
- **Floating particles** (6 animated elements)
- **Glassmorphism effects** on brand logo
- **Modern form inputs** with icons
- **Smooth animations**: slide-up, pulse, hover effects
- **Fully responsive design** for all devices
- **Professional error handling** with styled messages

### 🎨 Design Elements
- Inter font family from Google Fonts
- Purple gradient theme (#667eea → #764ba2)
- Icon-enhanced input fields
- Modern button with lift effect
- Touch-optimized for mobile

### 📁 Files Modified
- `resources/views/auth/login.blade.php` (complete rewrite, ~350 lines)

---

## Phase 1 - Critical Bug Fixes (2026-06-30)

### 🐛 Fixed
- **Pagination arrow bug**: Giant arrows blocking product pages
- **CSRF token expiration**: 419 PAGE EXPIRED error on login

### ✨ Added
- Comprehensive CSS overrides for pagination controls
- Extended session lifetime (120 minutes → 7200 minutes)
- Session configuration for localhost development

### 🔧 Changed
- Updated pagination styling in admin layout
- Updated pagination styling in user layout
- Modified `config/session.php` for longer sessions
- Added session config to `.env.example`

### 📁 Files Modified
- `resources/views/layouts/admin.blade.php` (pagination CSS)
- `resources/views/layouts/user.blade.php` (pagination CSS)
- `config/session.php`
- `.env.example`

---

## Phase 2 - Cart System (2026-06-25)

### ✨ Added
- **Shopping cart system** to replace direct ordering
- Session-based cart storage
- Cart operations: add, update, remove, clear
- **Comprehensive validations**:
  - Product must be active
  - Quantity > 0
  - Cannot exceed stock
  - Cart cannot be empty
- **Email notifications**:
  - `OrderPlaced` - sent to user
  - `OrderPlacedAdmin` - sent to admin
  - `OrderStatusUpdated` - sent to user on status changes
- Cart count badge in sidebar
- Modern product table view
- Product modals for details

### 🗑️ Removed
- Wishlist system (redundant with cart)
- Direct order creation route
- Wishlist references from navigation

### 🔧 Changed
- Order placement now requires cart
- Updated user dashboard to show cart items
- Converted product list from cards to table with modals
- Updated navigation menus

### 📁 Files Added
- `app/Http/Controllers/User/CartController.php`
- `app/Mail/OrderPlacedAdmin.php`
- `resources/views/user/cart/index.blade.php`
- `resources/views/emails/order-placed-admin.blade.php`

### 📁 Files Modified
- `app/Http/Controllers/User/OrderController.php`
- `resources/views/user/dashboard.blade.php`
- `resources/views/user/orders/index.blade.php`
- `resources/views/user/products/index.blade.php`
- `resources/views/layouts/user.blade.php`
- `routes/web.php`

---

## Reports Dashboard Enhancement (2026-06-22)

### ✨ Added
- **Low Stock Products Report**:
  - Dedicated page with table view
  - PDF export functionality
  - Shows products with stock ≤ 10
  - Proper date/time formatting in PDF
- Low Stock Products card on Reports Dashboard (link only)

### 🗑️ Removed
- Department-wise Orders chart (replaced)
- Low Stock Products analytics graph from dashboard

### 🔧 Changed
- Reports Dashboard now shows 3 charts only:
  - Monthly Orders Trend
  - Orders by Status (Pie Chart)
  - Top 10 Products

### 🐛 Fixed
- FullCalendar CSS leaking to other pages
- Giant arrow on product list pages
- Low stock logic (changed from < 10 to ≤ 10)
- PDF report date/time formatting

### 📁 Files Added
- `resources/views/admin/reports/low-stock.blade.php`
- `resources/views/admin/reports/pdf/low-stock.blade.php`

### 📁 Files Modified
- `app/Http/Controllers/Admin/ReportController.php`
- `resources/views/admin/reports/index.blade.php`
- `resources/views/admin/reports/calendar.blade.php`
- `routes/web.php`

---

## Dashboard Cleanup (2026-06-20)

### 🗑️ Removed
- Low Stock Products card from Admin Dashboard
- Low Stock chart from Reports Analytics

### 🔧 Changed
- Admin Dashboard now shows 9 cards (6 order status + 3 system stats)
- Cleaner, more focused dashboard layout

### 📁 Files Modified
- `app/Http/Controllers/Admin/DashboardController.php`
- `resources/views/admin/dashboard.blade.php`

---

## Unit Relationship Fix (2026-06-18)

### 🐛 Fixed
- Product-Unit relationship implementation
- Unit display in product listings
- Unit selection in product forms

### 📁 Files Modified
- `app/Models/Product.php`
- `app/Models/Unit.php`
- Various product views

---

## Initial Implementation (2026-06-15)

### ✨ Added
- Laravel 12.x project setup
- AdminLTE 3.2 integration
- Bootstrap 5 styling
- User authentication with roles (Admin, Lab Manager)
- Product management (CRUD)
- Category, Brand, Unit management
- Department management
- User management
- Order placement system
- Order approval workflow
- Dashboard with statistics
- Reports with charts
- Stock quantity tracking
- Email notification setup

### 📁 Initial Structure
- Complete MVC architecture
- Database migrations and seeders
- Route definitions
- Middleware for role-based access
- Blade layouts and components
- Email templates

---

## Git Branch Structure

### main
- Modern gradient UI
- All Phase 1-4 modernization
- Latest features
- Production-ready

### classic-ui
- Created from commit 082921f (before modernization)
- Original AdminLTE design
- Alternative UI option
- All cart system features included

---

## Documentation History

### 2026-06-30
- Created consolidated README.md
- Created DEVELOPMENT_GUIDE.md
- Created CHANGELOG.md
- Removed 20+ unnecessary MD files
- Organized all documentation

### Previous (2026-06-15 to 2026-06-29)
- Multiple scattered MD files for different phases
- Individual fix reports
- Implementation summaries
- Phase documentation

---

## Breaking Changes

### v1.0.0
- **Removed Wishlist**: Replaced with Cart system
- **Changed Order Flow**: Now requires cart before ordering
- **Removed Direct Order Route**: Use cart instead

---

## Upgrade Guide

### From Pre-Cart Version
1. Clear all caches
2. Run migrations (if any)
3. Update navigation links
4. Remove wishlist references
5. Test order placement through cart

### Switching Branches
```bash
# To modern UI
git checkout main
php artisan cache:clear
php artisan config:clear

# To classic UI
git checkout classic-ui
php artisan cache:clear
php artisan config:clear
```

---

## Known Issues

### None currently

All critical bugs have been fixed in v1.0.0

---

## Future Roadmap

### Planned Features
- [ ] Phase 5: Sidebar modernization
- [ ] Phase 6: Table modernization (all pages)
- [ ] Phase 7: Form modernization
- [ ] Advanced search and filtering
- [ ] Bulk order operations
- [ ] Order templates
- [ ] Automated reordering for low stock
- [ ] Multi-language support
- [ ] API for external integrations

### Under Consideration
- Mobile app
- Barcode scanning
- Advanced analytics
- Budget tracking
- Approval workflows with multiple levels

---

## Contributors

- **Smit Bhalani** - Initial development and modernization
- **Kiro AI** - Development assistance and optimization

---

## License

Proprietary software for university use.

---

**Last Updated**: June 30, 2026  
**Version**: 1.0.0  
**Status**: Production Ready
