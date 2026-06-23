<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    /**
     * Display the user dashboard.
     */
    public function index()
    {
        $user = auth()->user();
        
        // Statistics
        $totalOrders = $user->orders()->count();
        $pendingOrders = $user->orders()->where('status', 'pending')->count();
        $approvedOrders = $user->orders()->where('status', 'approved')->count();
        
        // Recent Orders
        $recentOrders = $user->orders()
            ->with('orderItems.product')
            ->latest()
            ->take(5)
            ->get();
        
        // Latest Products
        $latestProducts = Product::active()
            ->inStock()
            ->with(['category', 'brand'])
            ->latest()
            ->take(6)
            ->get();
        
        return view('user.dashboard', compact(
            'totalOrders',
            'pendingOrders',
            'approvedOrders',
            'recentOrders',
            'latestProducts'
        ));
    }
}
