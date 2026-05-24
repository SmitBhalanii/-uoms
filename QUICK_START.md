# 🚀 UOMS - Quick Start Guide

## ✅ Project is Running!

Your UOMS application is now running at: **http://localhost:8000**

---

## 🔐 Login Credentials

### Admin Account
```
URL:      http://localhost:8000/login
Email:    admin@uoms.com
Password: password
```

### Lab Manager Account
```
URL:      http://localhost:8000/login
Email:    labmanager@uoms.com
Password: password
```

---

## 📋 What to Test

### As Admin (admin@uoms.com)
1. ✅ View dashboard with statistics
2. ✅ Manage Departments (Create, Edit, Delete)
3. ✅ Manage Categories (Create, Edit, Delete)
4. ✅ Manage Units (Create, Edit, Delete)
5. ✅ Manage Products (Create with image, Edit, Delete)
6. ✅ View all orders from all users
7. ✅ Update order status
8. ✅ View Reports with charts

### As Lab Manager (labmanager@uoms.com)
1. ✅ View user dashboard
2. ✅ Browse products (15 sample products available)
3. ✅ Add products to wishlist
4. ✅ Place order from wishlist
5. ✅ View order history
6. ✅ Track order status
7. ✅ Update profile

---

## 📊 Sample Data Available

- **Departments:** 5 (Computer Lab, Electrical Lab, etc.)
- **Categories:** 6 (Electronics, Mechanical, etc.)
- **Units:** 6 (PCS, BOX, KG, LTR, SET, PACK)
- **Products:** 15 (Arduino, Raspberry Pi, USB Drive, etc.)
- **Users:** 2 (Admin and Lab Manager)

---

## 🛠️ Useful Commands

### Stop Server
```bash
Press Ctrl+C in the terminal
```

### Start Server Again
```bash
php artisan serve
```

### Reset Database (Fresh Start)
```bash
php artisan migrate:fresh --seed
```

### Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Check Email Logs
```bash
# Emails are logged to:
storage/logs/laravel.log
```

---

## 📁 Important Files

- **Complete Documentation:** `FINAL_PROJECT_SUMMARY.md`
- **Login Credentials:** `CREDENTIALS.md`
- **This Guide:** `QUICK_START.md`

---

## 🎯 Quick Test Flow

### Test Order Flow (5 minutes)
1. Login as Lab Manager
2. Go to Products
3. Add 2-3 products to wishlist
4. Go to Wishlist
5. Click "Place Order from Wishlist"
6. Enter quantities
7. Submit order
8. View Order History
9. Logout

10. Login as Admin
11. Go to Orders
12. Click on the new order
13. Update status to "Approved"
14. Add remarks
15. Submit

16. Login as Lab Manager again
17. Check Order History
18. See updated status

---

## ✨ Features to Explore

### Admin Features
- 📊 Dashboard with 8 statistics cards
- 🏢 Department Master CRUD
- 📁 Category Master CRUD
- 📏 Unit Master CRUD
- 📦 Product Master CRUD with image upload
- 🛒 Order Management with status updates
- 📈 Reports with Chart.js visualizations

### User Features
- 📊 Dashboard with order statistics
- 🔍 Product browsing with search and filter
- ❤️ Wishlist management
- 🛍️ Order placement from wishlist
- 📜 Order history with status tracking
- 👤 Profile management

---

## 🔔 Email Notifications

Emails are currently logged to `storage/logs/laravel.log`

**Emails Sent:**
- Order Placed (when user places order)
- Order Status Updated (when admin updates status)

To view emails, check the log file after placing an order or updating status.

---

## 🌐 GitHub Repository

**Repository:** https://github.com/SmitBhalanii/-uoms

All code is pushed and up to date!

---

## 💡 Tips

1. **Use Chrome DevTools** to inspect responsive design
2. **Check Network Tab** to see AJAX requests
3. **Try different screen sizes** to test responsiveness
4. **Test validation** by submitting empty forms
5. **Check status badges** - they're color-coded!

---

## 🆘 Need Help?

- Check `FINAL_PROJECT_SUMMARY.md` for complete documentation
- Check `CREDENTIALS.md` for all credentials
- Review troubleshooting section in documentation
- Contact: smitbhalani147@gmail.com

---

## 🎉 Enjoy Testing UOMS!

**Project Status:** ✅ COMPLETE & RUNNING

**Access URL:** http://localhost:8000

**Happy Testing! 🚀**
