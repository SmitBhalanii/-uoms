# 🎓 UOMS - University Order Management System

[![Laravel](https://img.shields.io/badge/Laravel-12-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://php.net)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)
[![AdminLTE](https://img.shields.io/badge/AdminLTE-3.2-blue.svg)](https://adminlte.io)

A professional University Order Management System built with Laravel 12, designed for university laboratory managers to efficiently order laboratory products and items from the university inventory system.

![UOMS Dashboard](https://via.placeholder.com/800x400/667eea/ffffff?text=UOMS+Dashboard)

## 📋 Table of Contents

- [Features](#-features)
- [Tech Stack](#-tech-stack)
- [Screenshots](#-screenshots)
- [Installation](#-installation)
- [Usage](#-usage)
- [Project Structure](#-project-structure)
- [Documentation](#-documentation)
- [Contributing](#-contributing)
- [License](#-license)

## ✨ Features

### 🔐 Authentication System
- ✅ User Registration
- ✅ User Login
- ✅ Password Reset
- ✅ Remember Me
- ✅ Profile Management
- ✅ Secure Password Hashing

### 👥 Role-Based Access Control (RBAC)
- **Admin (Master)**
  - Manage users
  - Manage inventory
  - Approve/reject orders
  - View reports
  - System settings
  
- **Lab Manager (User)**
  - Create orders
  - View order history
  - Browse available products
  - Track order status

### 🎨 Modern UI/UX
- Responsive AdminLTE 3.2 design
- Bootstrap 5 components
- Font Awesome icons
- Mobile-friendly interface
- Professional dashboard layouts

### 🏗️ Clean Architecture
- MVC pattern
- RESTful routing
- Eloquent ORM
- Blade templating
- Middleware protection
- Reusable components

## 🛠️ Tech Stack

| Technology | Version | Purpose |
|------------|---------|---------|
| **Laravel** | 12.x | PHP Framework |
| **PHP** | 8.2+ | Backend Language |
| **MySQL** | 8.0+ | Database |
| **Blade** | - | Template Engine |
| **AdminLTE** | 3.2 | Admin Template |
| **Bootstrap** | 5.3 | CSS Framework |
| **Laravel Breeze** | 2.x | Authentication |
| **Font Awesome** | 6.4 | Icons |

## 📸 Screenshots

### Admin Dashboard
![Admin Dashboard](https://via.placeholder.com/600x400/667eea/ffffff?text=Admin+Dashboard)

### User Dashboard
![User Dashboard](https://via.placeholder.com/600x400/48bb78/ffffff?text=User+Dashboard)

### Login Page
![Login Page](https://via.placeholder.com/600x400/ed8936/ffffff?text=Login+Page)

## 🚀 Installation

### Prerequisites

- PHP >= 8.2
- Composer
- MySQL >= 8.0
- Node.js & NPM

### Step-by-Step Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/uoms.git
   cd uoms
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node dependencies**
   ```bash
   npm install
   ```

4. **Create environment file**
   ```bash
   cp .env.example .env
   ```

5. **Generate application key**
   ```bash
   php artisan key:generate
   ```

6. **Configure database**
   
   Create a MySQL database:
   ```sql
   CREATE DATABASE uoms;
   ```
   
   Update `.env` file:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=uoms
   DB_USERNAME=root
   DB_PASSWORD=your_password
   ```

7. **Run migrations**
   ```bash
   php artisan migrate
   ```

8. **Seed database with test data**
   ```bash
   php artisan db:seed
   ```

9. **Build assets**
   ```bash
   npm run build
   ```

10. **Start development server**
    ```bash
    php artisan serve
    ```

11. **Access the application**
    
    Open your browser and visit: `http://localhost:8000`

## 🔑 Default Credentials

| Role | Email | Password | Dashboard |
|------|-------|----------|-----------|
| **Admin** | admin@uoms.com | password | /admin/dashboard |
| **Lab Manager** | user@uoms.com | password | /user/dashboard |

> ⚠️ **Important**: Change these credentials in production!

## 📖 Usage

### For Administrators

1. **Login** with admin credentials
2. **Manage Users**: Add, edit, or remove lab managers
3. **Manage Inventory**: Add products to the system
4. **Review Orders**: Approve or reject order requests
5. **Generate Reports**: View system statistics

### For Lab Managers

1. **Login** with user credentials
2. **Browse Products**: View available laboratory items
3. **Create Orders**: Submit order requests
4. **Track Orders**: Monitor order status
5. **View History**: Access past orders

## 📁 Project Structure

```
uoms/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/          # Admin controllers
│   │   │   ├── User/           # User controllers
│   │   │   └── Auth/           # Authentication controllers
│   │   └── Middleware/
│   │       ├── AdminMiddleware.php
│   │       └── UserMiddleware.php
│   └── Models/
│       └── User.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   └── views/
│       ├── layouts/
│       │   ├── admin.blade.php
│       │   └── user.blade.php
│       ├── admin/
│       └── user/
├── routes/
│   ├── web.php
│   └── auth.php
└── public/
```

## 📚 Documentation

Comprehensive documentation is available in the following files:

- **[SETUP_INSTRUCTIONS.md](SETUP_INSTRUCTIONS.md)** - Detailed setup guide
- **[ARCHITECTURE.md](ARCHITECTURE.md)** - System architecture documentation
- **[PROJECT_SUMMARY.md](PROJECT_SUMMARY.md)** - Project overview and features
- **[SYSTEM_DIAGRAMS.md](SYSTEM_DIAGRAMS.md)** - Visual system diagrams
- **[QUICK_REFERENCE.md](QUICK_REFERENCE.md)** - Quick reference guide
- **[GITHUB_SETUP.md](GITHUB_SETUP.md)** - GitHub setup instructions

## 🔄 Development Workflow

### Creating a New Feature

1. **Create a new branch**
   ```bash
   git checkout -b feature/new-feature
   ```

2. **Make your changes**
   ```bash
   # Edit files
   ```

3. **Commit changes**
   ```bash
   git add .
   git commit -m "Add: Description of new feature"
   ```

4. **Push to GitHub**
   ```bash
   git push origin feature/new-feature
   ```

5. **Create Pull Request** on GitHub

### Running Tests

```bash
php artisan test
```

### Code Style

```bash
# Format code with Laravel Pint
./vendor/bin/pint
```

## 🗺️ Roadmap

### Phase 1: Core Features ✅
- [x] Authentication system
- [x] Role-based access control
- [x] Admin dashboard
- [x] User dashboard
- [x] AdminLTE integration

### Phase 2: Product Management 🚧
- [ ] Product CRUD operations
- [ ] Category management
- [ ] Inventory tracking
- [ ] Product search and filters

### Phase 3: Order Management 📋
- [ ] Create order functionality
- [ ] Order approval workflow
- [ ] Order status tracking
- [ ] Order history

### Phase 4: Advanced Features 🚀
- [ ] Email notifications
- [ ] PDF report generation
- [ ] Advanced search
- [ ] Activity logs
- [ ] API endpoints

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

### Coding Standards

- Follow PSR-12 coding standards
- Write meaningful commit messages
- Add comments for complex logic
- Update documentation when needed

## 🐛 Bug Reports

If you discover a bug, please create an issue on GitHub with:

- Clear description of the bug
- Steps to reproduce
- Expected behavior
- Actual behavior
- Screenshots (if applicable)

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 👨‍💻 Author

**Your Name**
- GitHub: [@yourusername](https://github.com/yourusername)
- Email: your.email@example.com

## 🙏 Acknowledgments

- [Laravel](https://laravel.com) - The PHP Framework
- [AdminLTE](https://adminlte.io) - Admin Dashboard Template
- [Bootstrap](https://getbootstrap.com) - CSS Framework
- [Font Awesome](https://fontawesome.com) - Icon Library

## 📞 Support

For support and questions:

- 📧 Email: support@uoms.com
- 💬 Issues: [GitHub Issues](https://github.com/yourusername/uoms/issues)
- 📖 Documentation: [Wiki](https://github.com/yourusername/uoms/wiki)

## ⭐ Show Your Support

Give a ⭐️ if this project helped you!

---

**Built with ❤️ using Laravel 12**

---

## 📊 Project Stats

![GitHub stars](https://img.shields.io/github/stars/yourusername/uoms?style=social)
![GitHub forks](https://img.shields.io/github/forks/yourusername/uoms?style=social)
![GitHub issues](https://img.shields.io/github/issues/yourusername/uoms)
![GitHub pull requests](https://img.shields.io/github/issues-pr/yourusername/uoms)

---

© 2026 UOMS. All rights reserved.
