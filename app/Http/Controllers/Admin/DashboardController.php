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
        $processingOrders = Order::where('status', 'processing')->count();
        $approvedOrders = Order::where('status', 'approved')->count();
        $rejectedOrders = Order::where('status', 'rejected')->count();
        $completedOrders = Order::where('status', 'completed')->count();
        
        // Other Statistics
        $totalUsers = User::where('role', 'user')->count();
        $totalDepartments = Department::count();
        $totalProducts = Product::count();
        
        // Recent Orders
        $recentOrders = Order::with('user', 'orderItems')
            ->latest()
            ->take(10)
            ->get();
        
        return view('admin.dashboard', compact(
            'totalOrders',
            'pendingOrders',
            'processingOrders',
            'approvedOrders',
            'rejectedOrders',
            'completedOrders',
            'totalUsers',
            'totalDepartments',
            'totalProducts',
            'recentOrders'
        ));
    }
}
