# UOMS - University Order Management System

**Version**: 1.0.0  
**Laravel**: 12.x  
**Database**: SQLite  
**UI Framework**: AdminLTE 3.2 + Bootstrap 5

---

## 📋 Table of Contents

1. [About](#about)
2. [Features](#features)
3. [Installation](#installation)
4. [Login Credentials](#login-credentials)
5. [Branch Management](#branch-management)
6. [Troubleshooting](#troubleshooting)

---

## 📖 About

UOMS (University Order Management System) is a comprehensive web application for managing university laboratory equipment orders, inventory, and user requests. Built with Laravel and featuring both modern and classic UI options.

**Purpose**: Streamline lab equipment ordering, inventory management, and order approval workflows for universities.

---

## ✨ Features

### Admin Features
- **Dashboard**: Real-time statistics with modern gradient cards
- **Order Management**: Process, approve, reject, and complete orders
- **Inventory Control**: Manage products, stock levels, and low stock alerts
- **User Management**: Manage lab managers and their departments
- **Master Data**: Categories, brands, units, and departments
- **Reports**: Sales analytics, low stock reports, order calendar
- **Email Notifications**: Automatic notifications on order status changes

### User (Lab Manager) Features
- **Product Browsing**: Search and filter available products
- **Shopping Cart**: Add products, adjust quantities before ordering
- **Order Placement**: Submit orders with notes and requirements
- **Order Tracking**: View order status and history
- **Profile Management**: Update contact information and preferences

### System Features
- **Two UI Options**: Modern gradient design or classic AdminLTE
- **Responsive Design**: Works on desktop, tablet, and mobile
- **Session Management**: Extended sessions to prevent timeouts
- **CSRF Protection**: Secure against cross-site attacks
- **Email System**: Automated order notifications

---

## 🚀 Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js & NPM (for assets)
- SQLite (included in PHP)

### Setup Steps

1. **Clone the repository**
   ```bash
   git clone https://github.com/SmitBhalanii/-uoms.git
   cd uoms
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Configure environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Update .env file** - Add these session settings:
   ```env
   SESSION_DRIVER=database
   SESSION_LIFETIME=7200
   SESSION_SECURE_COOKIE=false
   SESSION_SAME_SITE=lax
   
   ADMIN_EMAIL=admin@example.com
   ```

5. **Setup database**
   ```bash
   touch database/database.sqlite
   php artisan migrate --seed
   ```

6. **Build assets**
   ```bash
   npm run build
   ```

7. **Clear caches and start**
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan serve
   ```

8. **Access the application**
   - URL: `http://127.0.0.1:8000`
   - Login with credentials below

---

## 🔐 Login Credentials

### Admin Account
- **Email**: `admin@uoms.com`
- **Password**: `password`
- **Role**: Administrator
- **Access**: Full system access

### Lab Manager Account  
- **Email**: `user@uoms.com`
- **Password**: `password`
- **Role**: Lab Manager
- **Access**: Product browsing, cart, orders

**⚠️ Change these passwords immediately in production!**

---

## 🎨 Modern UI Design

### Features
- **Modern Login Page**: Split-screen animated design with gradient background
- **Gradient Dashboard Cards**: Beautiful stat cards with hover effects and animations
- **Animated Counters**: Smooth number animations on page load
- **Modern Tables**: Gradient headers with professional styling
- **Custom Logo**: Gradient university icon with purple theme
- **Responsive Design**: Works perfectly on desktop, tablet, and mobile
- **Smooth Transitions**: Professional animations throughout

---

## 🐛 Troubleshooting

### 419 PAGE EXPIRED Error on Login

**Cause**: Session or CSRF token expired

**Solution**:
1. Clear all caches:
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan route:clear
   php artisan view:clear
   php artisan config:cache
   ```

2. Check `.env` has these settings:
   ```env
   SESSION_DRIVER=database
   SESSION_LIFETIME=7200
   SESSION_SECURE_COOKIE=false
   SESSION_SAME_SITE=lax
   ```

3. Restart server:
   ```bash
   # Press Ctrl+C to stop
   php artisan serve
   ```

4. Clear browser cache (Ctrl+Shift+Delete)

5. Try login again

**Alternative**: Use file-based sessions
```env
SESSION_DRIVER=file
```

### Storage Permission Issues

**Windows** (Run as Administrator):
```bash
icacls "d:\INSTALL LARAVEL\UOMS\uoms\storage" /grant Everyone:F /t
```

**Linux/Mac**:
```bash
chmod -R 775 storage bootstrap/cache
```

### Database Connection Issues

Check that `database/database.sqlite` exists:
```bash
# If missing, create it:
touch database/database.sqlite
php artisan migrate --seed
```

### Cache Issues After Updates

Always run after code changes:
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
composer dump-autoload
```

### Session Table Missing

```bash
php artisan session:table
php artisan migrate
```

---

## 📞 Support

For issues or questions:
1. Check this README first
2. See `DEVELOPMENT_GUIDE.md` for detailed documentation
3. Review `CHANGELOG.md` for recent changes
4. Create an issue on GitHub

---

## 📄 License

This project is proprietary software developed for university use.

---

## 🎉 Quick Start Summary

```bash
# 1. Install
composer install && npm install

# 2. Setup
cp .env.example .env && php artisan key:generate

# 3. Database  
touch database/database.sqlite && php artisan migrate --seed

# 4. Build
npm run build

# 5. Clear & Start
php artisan cache:clear && php artisan config:clear && php artisan serve

# 6. Login
# URL: http://127.0.0.1:8000
# Admin: admin@uoms.com / password
# User: user@uoms.com / password
```

**You're ready to go!** 🚀
