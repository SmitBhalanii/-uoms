# UOMS (University Order Management System) - Setup Instructions

## Project Overview
UOMS is a University Order Management System built with Laravel 12, designed for university laboratory managers to order laboratory products/items from the university inventory system.

## Tech Stack
- Laravel 12
- MySQL
- Blade Templates
- Bootstrap 5
- AdminLTE 3.2
- Laravel Breeze Authentication

## Prerequisites
- PHP >= 8.2
- Composer
- MySQL
- Node.js & NPM

## Installation Steps

### 1. Database Setup
Create a MySQL database named `uoms`:
```sql
CREATE DATABASE uoms;
```

### 2. Configure Environment
The `.env` file is already configured with:
- APP_NAME=UOMS
- DB_CONNECTION=mysql
- DB_DATABASE=uoms
- DB_USERNAME=root
- DB_PASSWORD= (update if needed)

Update the database credentials if necessary.

### 3. Run Migrations
```bash
php artisan migrate
```

### 4. Seed Database
```bash
php artisan db:seed
```

This will create test users:
- **Admin**: admin@uoms.com / password
- **Lab Manager**: user@uoms.com / password
- **Additional Users**: john@uoms.com, jane@uoms.com / password

### 5. Start Development Server
```bash
php artisan serve
```

Visit: http://localhost:8000

## User Roles

### 1. Admin (Master)
- Email: admin@uoms.com
- Password: password
- Dashboard: /admin/dashboard
- Capabilities:
  - Manage users
  - Manage inventory
  - Approve/reject orders
  - View reports
  - System settings

### 2. Lab Manager (User)
- Email: user@uoms.com
- Password: password
- Dashboard: /user/dashboard
- Capabilities:
  - Create orders
  - View order history
  - Browse available products
  - Manage profile

## Authentication Features
- ✅ Login
- ✅ Register
- ✅ Forgot Password
- ✅ Change Password
- ✅ Logout
- ✅ Role-based redirect after login

## Project Structure

```
uoms/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   └── DashboardController.php
│   │   │   ├── User/
│   │   │   │   └── DashboardController.php
│   │   │   └── Auth/
│   │   │       └── AuthenticatedSessionController.php
│   │   └── Middleware/
│   │       ├── AdminMiddleware.php
│   │       └── UserMiddleware.php
│   └── Models/
│       └── User.php
├── database/
│   ├── migrations/
│   │   └── 2026_05_24_112527_add_role_to_users_table.php
│   └── seeders/
│       ├── DatabaseSeeder.php
│       └── UserSeeder.php
├── resources/
│   └── views/
│       ├── layouts/
│       │   ├── admin.blade.php
│       │   └── user.blade.php
│       ├── admin/
│       │   └── dashboard.blade.php
│       ├── user/
│       │   └── dashboard.blade.php
│       └── auth/
│           ├── login.blade.php
│           ├── register.blade.php
│           └── forgot-password.blade.php
├── routes/
│   └── web.php
└── bootstrap/
    └── app.php
```

## Routes Structure

### Public Routes
- `GET /` - Welcome page

### Authentication Routes (via Breeze)
- `GET /login` - Login page
- `POST /login` - Login action
- `GET /register` - Register page
- `POST /register` - Register action
- `GET /forgot-password` - Forgot password page
- `POST /forgot-password` - Forgot password action
- `POST /logout` - Logout action

### Admin Routes (Middleware: auth, admin)
- `GET /admin/dashboard` - Admin dashboard

### User Routes (Middleware: auth, user)
- `GET /user/dashboard` - Lab Manager dashboard

### Profile Routes (Middleware: auth)
- `GET /profile` - Edit profile
- `PATCH /profile` - Update profile
- `DELETE /profile` - Delete profile

## Middleware Flow

### 1. AdminMiddleware
- **Location**: `app/Http/Middleware/AdminMiddleware.php`
- **Purpose**: Protect admin routes
- **Logic**: 
  - Checks if user is authenticated
  - Checks if user role is 'admin'
  - Returns 403 if unauthorized

### 2. UserMiddleware
- **Location**: `app/Http/Middleware/UserMiddleware.php`
- **Purpose**: Protect user routes
- **Logic**:
  - Checks if user is authenticated
  - Checks if user role is 'user'
  - Returns 403 if unauthorized

### 3. Middleware Registration
- **Location**: `bootstrap/app.php`
- **Aliases**:
  - `admin` → AdminMiddleware
  - `user` → UserMiddleware

## Authentication Flow

### Login Process
1. User visits `/login`
2. User enters credentials
3. `AuthenticatedSessionController@store` validates credentials
4. System checks user role:
   - If `admin` → Redirect to `/admin/dashboard`
   - If `user` → Redirect to `/user/dashboard`
5. Session is created and user is authenticated

### Registration Process
1. User visits `/register`
2. User fills registration form
3. User is created with default role `user`
4. User is redirected to `/user/dashboard`

### Logout Process
1. User clicks logout
2. Session is invalidated
3. User is redirected to `/`

## Dashboard Rendering

### Admin Dashboard
1. Route: `/admin/dashboard`
2. Middleware: `auth`, `admin`
3. Controller: `Admin\DashboardController@index`
4. View: `resources/views/admin/dashboard.blade.php`
5. Layout: `resources/views/layouts/admin.blade.php`

**Features**:
- Statistics cards (Total Orders, Lab Managers, Pending Orders, Products)
- Recent orders table
- Quick stats panel

### User Dashboard
1. Route: `/user/dashboard`
2. Middleware: `auth`, `user`
3. Controller: `User\DashboardController@index`
4. View: `resources/views/user/dashboard.blade.php`
5. Layout: `resources/views/layouts/user.blade.php`

**Features**:
- Statistics cards (My Orders, Approved Orders, Pending Orders, Available Products)
- Recent orders table with actions
- Quick actions panel
- Notifications panel

## Layout Structure

### Admin Layout (`layouts/admin.blade.php`)
- **Navbar**: Logo, menu toggle, user dropdown
- **Sidebar**: 
  - User panel with avatar
  - Navigation menu (Dashboard, Users, Inventory, Orders, Reports, Settings)
- **Content Area**: Dynamic content with breadcrumbs
- **Footer**: Copyright and version info

### User Layout (`layouts/user.blade.php`)
- **Navbar**: Logo, menu toggle, user dropdown
- **Sidebar**:
  - User panel with avatar
  - Navigation menu (Dashboard, My Orders, Create Order, Products, History, Profile)
- **Content Area**: Dynamic content with breadcrumbs
- **Footer**: Copyright and version info

## Development Best Practices

### 1. MVC Architecture
- **Models**: Handle database interactions
- **Views**: Handle presentation (Blade templates)
- **Controllers**: Handle business logic

### 2. Naming Conventions
- Controllers: PascalCase (e.g., `DashboardController`)
- Methods: camelCase (e.g., `index()`)
- Routes: kebab-case (e.g., `/admin/dashboard`)
- Views: kebab-case (e.g., `admin.dashboard`)

### 3. Folder Structure
- Admin controllers in `app/Http/Controllers/Admin/`
- User controllers in `app/Http/Controllers/User/`
- Admin views in `resources/views/admin/`
- User views in `resources/views/user/`

### 4. Middleware Usage
- Always protect routes with appropriate middleware
- Use route groups for better organization
- Register middleware aliases in `bootstrap/app.php`

### 5. Blade Layouts
- Use `@extends` to inherit layouts
- Use `@section` to define content areas
- Use `@yield` in layouts for dynamic content
- Use `@stack` for scripts and styles

## Next Steps

### Recommended Features to Implement
1. **Products/Inventory Module**
   - CRUD operations for products
   - Categories management
   - Stock tracking

2. **Orders Module**
   - Create order functionality
   - Order approval workflow
   - Order status tracking
   - Order history

3. **User Management (Admin)**
   - CRUD operations for users
   - Role assignment
   - User activity logs

4. **Reports Module**
   - Order reports
   - Inventory reports
   - User activity reports

5. **Notifications**
   - Email notifications
   - In-app notifications
   - Order status updates

## Troubleshooting

### Common Issues

1. **403 Unauthorized Error**
   - Check user role in database
   - Verify middleware is applied correctly
   - Clear cache: `php artisan cache:clear`

2. **Database Connection Error**
   - Verify MySQL is running
   - Check `.env` database credentials
   - Ensure database exists

3. **Assets Not Loading**
   - Run: `npm install && npm run build`
   - Check public folder permissions

4. **Session Issues**
   - Clear sessions: `php artisan session:clear`
   - Check session driver in `.env`

## Support
For issues or questions, refer to:
- Laravel Documentation: https://laravel.com/docs
- AdminLTE Documentation: https://adminlte.io/docs
- Bootstrap Documentation: https://getbootstrap.com/docs

## License
This project is for educational/internship purposes.
