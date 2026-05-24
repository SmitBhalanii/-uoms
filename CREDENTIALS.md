# UOMS - Login Credentials

## Demo Accounts

### 🔐 Admin Account
```
Email:    admin@uoms.com
Password: password
Role:     admin
Access:   Full administrative access
```

**Admin Capabilities:**
- ✅ Access admin dashboard
- ✅ Manage departments, categories, units
- ✅ Manage products with image upload
- ✅ View all orders from all users
- ✅ Update order status (pending/approved/rejected/processing/completed)
- ✅ Add admin remarks to orders
- ✅ View comprehensive reports and analytics
- ✅ View charts (monthly orders, status distribution)
- ❌ Cannot access user routes

---

### 👤 Lab Manager Account
```
Email:    labmanager@uoms.com
Password: password
Role:     user
Access:   Lab manager access
```

**Lab Manager Capabilities:**
- ✅ Access user dashboard
- ✅ Browse all products
- ✅ Search and filter products
- ✅ Add products to wishlist
- ✅ Place orders from wishlist
- ✅ View order history
- ✅ Track order status
- ✅ Update profile information
- ✅ Change password
- ❌ Cannot access admin routes

---

## Quick Login URLs

**Admin Login:**
```
URL: http://localhost:8000/login
Then use admin credentials above
```

**Lab Manager Login:**
```
URL: http://localhost:8000/login
Then use lab manager credentials above
```

---

## Database Credentials

### SQLite (Default - Development)
```
DB_CONNECTION=sqlite
Database File: database/database.sqlite
```

### MySQL (Production)
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=uoms
DB_USERNAME=root
DB_PASSWORD=your_password_here
```

---

## Email Configuration

### Development (Current)
```
MAIL_MAILER=log
Emails saved to: storage/logs/laravel.log
```

### Production (SMTP)
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@uoms.edu
MAIL_FROM_NAME="UOMS System"
```

---

## Application URLs

### Development Server
```
Main URL:        http://localhost:8000
Admin Dashboard: http://localhost:8000/admin/dashboard
User Dashboard:  http://localhost:8000/user/dashboard
```

### After Login Redirects
```
Admin → /admin/dashboard
User  → /user/dashboard
```

---

## Sample Data Included

### Departments (5)
- Computer Lab
- Electrical Lab
- Chemistry Lab
- Physics Lab
- Mechanical Lab

### Categories (6)
- Electronics
- Mechanical
- Computer Accessories
- Laboratory Equipment
- Chemicals
- Safety Equipment

### Units (6)
- Pieces (PCS)
- Box (BOX)
- Kilogram (KG)
- Liter (LTR)
- Set (SET)
- Pack (PACK)

### Products (15)
- Arduino Uno R3
- Raspberry Pi 4 Model B
- USB Flash Drive 32GB
- Wireless Mouse
- Digital Multimeter
- Beaker Set
- Distilled Water
- Sodium Chloride
- Safety Goggles
- Latex Gloves
- Screwdriver Set
- Digital Caliper
- Resistor Kit
- Hot Plate Stirrer
- HDMI Cable 2m

---

## Security Notes

⚠️ **IMPORTANT FOR PRODUCTION:**

1. **Change Default Passwords**
   - Never use 'password' in production
   - Use strong, unique passwords
   - Consider password managers

2. **Update .env File**
   - Set APP_ENV=production
   - Set APP_DEBUG=false
   - Generate new APP_KEY
   - Update all credentials

3. **Database Security**
   - Use strong database passwords
   - Restrict database access
   - Regular backups

4. **Email Security**
   - Use app-specific passwords
   - Enable 2FA on email accounts
   - Use dedicated SMTP service

5. **Server Security**
   - Keep PHP and Laravel updated
   - Use HTTPS (SSL certificate)
   - Configure firewall
   - Regular security audits

---

## Testing Workflow

### Admin Testing
1. Login as admin@uoms.com
2. View dashboard statistics
3. Create/Edit departments, categories, units
4. Add products with images
5. View all orders
6. Update order status
7. Check reports and charts

### User Testing
1. Login as labmanager@uoms.com
2. View user dashboard
3. Browse products
4. Add products to wishlist
5. Place order from wishlist
6. View order history
7. Check order details
8. Update profile

---

## Support

For any issues or questions:
- Check FINAL_PROJECT_SUMMARY.md
- Review troubleshooting section
- Contact: smitbhalani147@gmail.com
- GitHub: https://github.com/SmitBhalanii/-uoms

---

*Keep these credentials secure and never commit them to public repositories!*
