# UOMS - System Diagrams

## Visual Guide to System Architecture

---

## 1. Overall System Architecture

```
┌─────────────────────────────────────────────────────────────┐
│                         BROWSER                              │
│                    (User Interface)                          │
└────────────────────────┬────────────────────────────────────┘
                         │ HTTP Request
                         ▼
┌─────────────────────────────────────────────────────────────┐
│                    LARAVEL APPLICATION                       │
│                                                              │
│  ┌──────────────────────────────────────────────────────┐  │
│  │                    ROUTES (web.php)                   │  │
│  │  - Public Routes                                      │  │
│  │  - Auth Routes (Breeze)                              │  │
│  │  - Admin Routes (middleware: auth, admin)            │  │
│  │  - User Routes (middleware: auth, user)              │  │
│  └────────────────────┬─────────────────────────────────┘  │
│                       │                                      │
│                       ▼                                      │
│  ┌──────────────────────────────────────────────────────┐  │
│  │                   MIDDLEWARE                          │  │
│  │  - Authenticate (auth)                               │  │
│  │  - AdminMiddleware (admin)                           │  │
│  │  - UserMiddleware (user)                             │  │
│  └────────────────────┬─────────────────────────────────┘  │
│                       │                                      │
│                       ▼                                      │
│  ┌──────────────────────────────────────────────────────┐  │
│  │                  CONTROLLERS                          │  │
│  │  ┌─────────────────────┐  ┌─────────────────────┐   │  │
│  │  │  Admin Controllers  │  │  User Controllers   │   │  │
│  │  │  - Dashboard        │  │  - Dashboard        │   │  │
│  │  │  - Users            │  │  - Orders           │   │  │
│  │  │  - Products         │  │  - Products         │   │  │
│  │  │  - Orders           │  │  - Profile          │   │  │
│  │  └─────────────────────┘  └─────────────────────┘   │  │
│  └────────────────────┬─────────────────────────────────┘  │
│                       │                                      │
│                       ▼                                      │
│  ┌──────────────────────────────────────────────────────┐  │
│  │                     MODELS                            │  │
│  │  - User (with role field)                            │  │
│  │  - Product (future)                                  │  │
│  │  - Order (future)                                    │  │
│  └────────────────────┬─────────────────────────────────┘  │
│                       │                                      │
│                       ▼                                      │
│  ┌──────────────────────────────────────────────────────┐  │
│  │                     VIEWS                             │  │
│  │  ┌─────────────────────┐  ┌─────────────────────┐   │  │
│  │  │   Admin Views       │  │    User Views       │   │  │
│  │  │  - admin.dashboard  │  │  - user.dashboard   │   │  │
│  │  │  - admin.users      │  │  - user.orders      │   │  │
│  │  │  - admin.products   │  │  - user.products    │   │  │
│  │  └─────────────────────┘  └─────────────────────┘   │  │
│  │                                                       │  │
│  │  ┌──────────────────────────────────────────────┐   │  │
│  │  │            LAYOUTS                            │   │  │
│  │  │  - layouts.admin (AdminLTE)                  │   │  │
│  │  │  - layouts.user (AdminLTE)                   │   │  │
│  │  │  - layouts.guest (Breeze)                    │   │  │
│  │  └──────────────────────────────────────────────┘   │  │
│  └──────────────────────────────────────────────────────┘  │
└────────────────────────┬────────────────────────────────────┘
                         │
                         ▼
┌─────────────────────────────────────────────────────────────┐
│                    DATABASE (MySQL)                          │
│  - users (id, name, email, password, role)                  │
│  - password_reset_tokens                                     │
│  - sessions                                                  │
│  - cache                                                     │
└─────────────────────────────────────────────────────────────┘
```

---

## 2. Authentication Flow Diagram

```
┌──────────────┐
│   Browser    │
└──────┬───────┘
       │
       │ 1. Visit /login
       ▼
┌──────────────────────────────────────┐
│  AuthenticatedSessionController      │
│  @create                             │
│  → Display login form                │
└──────┬───────────────────────────────┘
       │
       │ 2. Submit credentials
       ▼
┌──────────────────────────────────────┐
│  LoginRequest                        │
│  → Validate credentials              │
│  → Authenticate user                 │
└──────┬───────────────────────────────┘
       │
       │ 3. Authentication successful
       ▼
┌──────────────────────────────────────┐
│  AuthenticatedSessionController      │
│  @store                              │
│  → Get authenticated user            │
│  → Check user role                   │
└──────┬───────────────────────────────┘
       │
       │ 4. Role-based redirect
       ▼
    ┌──┴──┐
    │ IF  │
    └──┬──┘
       │
   ┌───┴────────────────────┐
   │                        │
   ▼                        ▼
role='admin'           role='user'
   │                        │
   ▼                        ▼
/admin/dashboard      /user/dashboard
   │                        │
   ▼                        ▼
┌─────────────┐      ┌─────────────┐
│   Admin     │      │    User     │
│  Dashboard  │      │  Dashboard  │
└─────────────┘      └─────────────┘
```

---

## 3. Middleware Flow Diagram

```
HTTP Request
     │
     ▼
┌─────────────────────────────────────┐
│   Global Middleware (Laravel)       │
│   - TrustProxies                    │
│   - HandleCors                      │
│   - ValidatePostSize                │
│   - TrimStrings                     │
└─────────────┬───────────────────────┘
              │
              ▼
┌─────────────────────────────────────┐
│   Route Middleware: 'auth'          │
│   (Authenticate)                    │
└─────────────┬───────────────────────┘
              │
              ├─── Is authenticated? ───┐
              │                         │
              ▼ YES                     ▼ NO
              │                    Redirect to /login
              │
              ▼
┌─────────────────────────────────────┐
│   Route Middleware: 'admin' or      │
│   'user'                            │
└─────────────┬───────────────────────┘
              │
        ┌─────┴─────┐
        │           │
        ▼           ▼
   AdminMiddleware  UserMiddleware
        │           │
        │           │
   Check role       Check role
   == 'admin'       == 'user'
        │           │
    ┌───┴───┐   ┌───┴───┐
    │       │   │       │
    ▼ YES   ▼NO ▼ YES   ▼NO
    │       │   │       │
    │    403    │    403
    │   Error   │   Error
    │           │
    ▼           ▼
┌─────────────────────────────────────┐
│         Controller Action           │
└─────────────┬───────────────────────┘
              │
              ▼
         HTTP Response
```

---

## 4. Route Structure Diagram

```
UOMS Routes
│
├── Public Routes
│   └── GET / → welcome view
│
├── Authentication Routes (Breeze)
│   ├── GET  /login → login form
│   ├── POST /login → authenticate
│   ├── GET  /register → register form
│   ├── POST /register → create user
│   ├── GET  /forgot-password → forgot password form
│   ├── POST /forgot-password → send reset link
│   ├── GET  /reset-password/{token} → reset form
│   ├── POST /reset-password → reset password
│   └── POST /logout → logout user
│
├── Admin Routes [middleware: auth, admin]
│   ├── Prefix: /admin
│   ├── Name: admin.*
│   │
│   └── GET /admin/dashboard → Admin\DashboardController@index
│       └── View: admin.dashboard
│       └── Layout: layouts.admin
│
├── User Routes [middleware: auth, user]
│   ├── Prefix: /user
│   ├── Name: user.*
│   │
│   └── GET /user/dashboard → User\DashboardController@index
│       └── View: user.dashboard
│       └── Layout: layouts.user
│
└── Profile Routes [middleware: auth]
    ├── GET    /profile → ProfileController@edit
    ├── PATCH  /profile → ProfileController@update
    └── DELETE /profile → ProfileController@destroy
```

---

## 5. Database Schema Diagram

```
┌─────────────────────────────────────────────────────┐
│                    USERS TABLE                       │
├──────────────┬──────────────────┬───────────────────┤
│ Field        │ Type             │ Description       │
├──────────────┼──────────────────┼───────────────────┤
│ id           │ BIGINT UNSIGNED  │ Primary Key       │
│ name         │ VARCHAR(255)     │ User's name       │
│ email        │ VARCHAR(255)     │ Unique email      │
│ password     │ VARCHAR(255)     │ Hashed password   │
│ role         │ ENUM             │ 'admin' or 'user' │
│              │                  │ Default: 'user'   │
│ remember_token│ VARCHAR(100)    │ Remember me token │
│ created_at   │ TIMESTAMP        │ Creation time     │
│ updated_at   │ TIMESTAMP        │ Update time       │
└──────────────┴──────────────────┴───────────────────┘

Future Tables (Recommended):

┌─────────────────────────────────────────────────────┐
│                  PRODUCTS TABLE                      │
├──────────────┬──────────────────┬───────────────────┤
│ id           │ BIGINT UNSIGNED  │ Primary Key       │
│ name         │ VARCHAR(255)     │ Product name      │
│ description  │ TEXT             │ Description       │
│ category_id  │ BIGINT UNSIGNED  │ Foreign Key       │
│ quantity     │ INT              │ Stock quantity    │
│ unit         │ VARCHAR(50)      │ Unit (pcs, kg)    │
│ price        │ DECIMAL(10,2)    │ Unit price        │
│ created_at   │ TIMESTAMP        │                   │
│ updated_at   │ TIMESTAMP        │                   │
└──────────────┴──────────────────┴───────────────────┘

┌─────────────────────────────────────────────────────┐
│                   ORDERS TABLE                       │
├──────────────┬──────────────────┬───────────────────┤
│ id           │ BIGINT UNSIGNED  │ Primary Key       │
│ user_id      │ BIGINT UNSIGNED  │ FK → users.id     │
│ order_number │ VARCHAR(50)      │ Unique order #    │
│ status       │ ENUM             │ pending/approved  │
│ total_amount │ DECIMAL(10,2)    │ Total cost        │
│ notes        │ TEXT             │ Order notes       │
│ created_at   │ TIMESTAMP        │                   │
│ updated_at   │ TIMESTAMP        │                   │
└──────────────┴──────────────────┴───────────────────┘
         │
         │ One-to-Many
         ▼
┌─────────────────────────────────────────────────────┐
│                ORDER_ITEMS TABLE                     │
├──────────────┬──────────────────┬───────────────────┤
│ id           │ BIGINT UNSIGNED  │ Primary Key       │
│ order_id     │ BIGINT UNSIGNED  │ FK → orders.id    │
│ product_id   │ BIGINT UNSIGNED  │ FK → products.id  │
│ quantity     │ INT              │ Order quantity    │
│ unit_price   │ DECIMAL(10,2)    │ Price per unit    │
│ subtotal     │ DECIMAL(10,2)    │ quantity × price  │
│ created_at   │ TIMESTAMP        │                   │
│ updated_at   │ TIMESTAMP        │                   │
└──────────────┴──────────────────┴───────────────────┘
```

---

## 6. MVC Pattern Diagram

```
┌─────────────────────────────────────────────────────┐
│                    MVC PATTERN                       │
└─────────────────────────────────────────────────────┘

User Request
     │
     ▼
┌─────────────────────────────────────────────────────┐
│                    CONTROLLER                        │
│  (Business Logic & Request Handling)                │
│                                                      │
│  class DashboardController extends Controller       │
│  {                                                   │
│      public function index()                        │
│      {                                               │
│          // 1. Get data from Model                  │
│          $stats = Order::getStatistics();           │
│                                                      │
│          // 2. Pass data to View                    │
│          return view('admin.dashboard',             │
│                     compact('stats'));              │
│      }                                               │
│  }                                                   │
└──────────────┬──────────────────────┬───────────────┘
               │                      │
               │ Requests data        │ Returns view
               ▼                      ▼
┌──────────────────────┐    ┌──────────────────────┐
│       MODEL          │    │        VIEW          │
│  (Data & Logic)      │    │   (Presentation)     │
│                      │    │                      │
│  class Order         │    │  admin/dashboard     │
│  extends Model       │    │  .blade.php          │
│  {                   │    │                      │
│    public static     │    │  @extends('layouts   │
│    function          │    │   .admin')           │
│    getStatistics()   │    │                      │
│    {                 │    │  @section('content') │
│      return DB::     │    │    <div>             │
│        table('orders')│   │      {{ $stats }}    │
│        ->count();    │    │    </div>            │
│    }                 │    │  @endsection         │
│  }                   │    │                      │
└──────────┬───────────┘    └──────────┬───────────┘
           │                           │
           │ Interacts with            │ Uses
           ▼                           ▼
┌──────────────────────┐    ┌──────────────────────┐
│      DATABASE        │    │       LAYOUT         │
│  (MySQL)             │    │  (layouts/admin)     │
│                      │    │                      │
│  - users             │    │  - Navbar            │
│  - orders            │    │  - Sidebar           │
│  - products          │    │  - @yield('content') │
│  - order_items       │    │  - Footer            │
└──────────────────────┘    └──────────────────────┘
```

---

## 7. Blade Layout Inheritance Diagram

```
┌─────────────────────────────────────────────────────┐
│         layouts/admin.blade.php (Master)            │
│                                                      │
│  <!DOCTYPE html>                                    │
│  <html>                                             │
│  <head>                                             │
│    <title>@yield('title')</title>                  │
│    @stack('styles')                                 │
│  </head>                                            │
│  <body>                                             │
│    <nav>...</nav>                                   │
│    <aside>...</aside>                               │
│    <div class="content-wrapper">                   │
│      <h1>@yield('page-title')</h1>                 │
│      <ol>@yield('breadcrumb')</ol>                 │
│      @yield('content')  ← Child content here       │
│    </div>                                           │
│    <footer>...</footer>                             │
│    @stack('scripts')                                │
│  </body>                                            │
│  </html>                                            │
└─────────────────────────────────────────────────────┘
                         ▲
                         │ @extends
                         │
┌─────────────────────────────────────────────────────┐
│       admin/dashboard.blade.php (Child)             │
│                                                      │
│  @extends('layouts.admin')                          │
│                                                      │
│  @section('page-title', 'Admin Dashboard')          │
│                                                      │
│  @section('breadcrumb')                             │
│    <li>Dashboard</li>                               │
│  @endsection                                        │
│                                                      │
│  @section('content')                                │
│    <div class="row">                                │
│      <div class="col-md-3">                         │
│        <div class="small-box">...</div>             │
│      </div>                                         │
│    </div>                                           │
│  @endsection                                        │
│                                                      │
│  @push('scripts')                                   │
│    <script>console.log('Dashboard loaded');</script>│
│  @endpush                                           │
└─────────────────────────────────────────────────────┘
```

---

## 8. User Role Flow Diagram

```
┌─────────────────────────────────────────────────────┐
│                  USER REGISTRATION                   │
└─────────────────────────────────────────────────────┘

New User
   │
   ▼
Register Form
   │
   ▼
Create User
   │
   ├─→ name: "John Doe"
   ├─→ email: "john@uoms.com"
   ├─→ password: (hashed)
   └─→ role: "user" (DEFAULT)
   │
   ▼
Auto Login
   │
   ▼
Redirect to /user/dashboard


┌─────────────────────────────────────────────────────┐
│                    USER LOGIN                        │
└─────────────────────────────────────────────────────┘

User Login
   │
   ▼
Authenticate
   │
   ▼
Get User Role
   │
   ├─────────────┬─────────────┐
   │             │             │
   ▼             ▼             ▼
role='admin'  role='user'   Other
   │             │             │
   ▼             ▼             ▼
/admin/       /user/        Error
dashboard     dashboard


┌─────────────────────────────────────────────────────┐
│                 ROUTE ACCESS CONTROL                 │
└─────────────────────────────────────────────────────┘

Admin tries to access /user/dashboard
   │
   ▼
UserMiddleware checks role
   │
   ▼
role != 'user'
   │
   ▼
403 Forbidden


User tries to access /admin/dashboard
   │
   ▼
AdminMiddleware checks role
   │
   ▼
role != 'admin'
   │
   ▼
403 Forbidden
```

---

## 9. Request Lifecycle Diagram

```
┌─────────────────────────────────────────────────────┐
│         COMPLETE REQUEST LIFECYCLE                   │
└─────────────────────────────────────────────────────┘

1. Browser Request
   │
   ▼
2. public/index.php (Entry Point)
   │
   ▼
3. bootstrap/app.php (Bootstrap Application)
   │
   ▼
4. Load Environment (.env)
   │
   ▼
5. Load Configuration (config/)
   │
   ▼
6. Register Service Providers
   │
   ▼
7. Route Matching (routes/web.php)
   │
   ▼
8. Global Middleware
   │
   ▼
9. Route Middleware (auth, admin/user)
   │
   ▼
10. Controller Action
    │
    ▼
11. Model Interaction (if needed)
    │
    ▼
12. Database Query (if needed)
    │
    ▼
13. View Rendering (Blade)
    │
    ▼
14. Response Middleware
    │
    ▼
15. Send Response to Browser
```

---

## 10. File Organization Diagram

```
app/Http/Controllers/
│
├── Admin/                    ← Admin controllers
│   ├── DashboardController.php
│   ├── UserController.php (future)
│   ├── ProductController.php (future)
│   └── OrderController.php (future)
│
├── User/                     ← User controllers
│   ├── DashboardController.php
│   ├── OrderController.php (future)
│   └── ProductController.php (future)
│
├── Auth/                     ← Auth controllers (Breeze)
│   ├── AuthenticatedSessionController.php
│   ├── RegisteredUserController.php
│   └── PasswordResetLinkController.php
│
└── ProfileController.php     ← Shared profile controller


resources/views/
│
├── layouts/                  ← Reusable layouts
│   ├── admin.blade.php
│   ├── user.blade.php
│   └── guest.blade.php
│
├── admin/                    ← Admin views
│   ├── dashboard.blade.php
│   ├── users/
│   ├── products/
│   └── orders/
│
├── user/                     ← User views
│   ├── dashboard.blade.php
│   ├── orders/
│   └── products/
│
├── auth/                     ← Auth views (Breeze)
│   ├── login.blade.php
│   ├── register.blade.php
│   └── forgot-password.blade.php
│
└── profile/                  ← Profile views
    └── edit.blade.php
```

---

These diagrams provide a visual understanding of how the UOMS system is structured and how different components interact with each other.
