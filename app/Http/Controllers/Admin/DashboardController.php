<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        // Order Statistics
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $approvedOrders = Order::where('status', 'approved')->count();
        $rejectedOrders = Order::where('status', 'rejected')->count();
        
        // Other Statistics
        $totalUsers = User::where('role', 'user')->count();
        $totalDepartments = Department::count();
        $totalProducts = Product::count();
        $lowStockProducts = Product::where('stock_quantity', '<', 10)->count();
        
        // Recent Orders
        $recentOrders = Order::with('user', 'orderItems')
            ->latest()
            ->take(10)
            ->get();
        
        return view('admin.dashboard', compact(
            'totalOrders',
            'pendingOrders',
            'approvedOrders',
            'rejectedOrders',
            'totalUsers',
            'totalDepartments',
            'totalProducts',
            'lowStockProducts',
            'recentOrders'
        ));
    }
}
