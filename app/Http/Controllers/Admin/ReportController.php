<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display reports dashboard.
     */
    public function index(Request $request)
    {
        // Monthly Orders Report
        $monthlyOrders = Order::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('COUNT(*) as total_orders'),
                DB::raw('SUM(total_items) as total_items')
            )
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->limit(12)
            ->get();
        
        // Department-wise Orders
        $departmentOrders = User::select('department', DB::raw('COUNT(orders.id) as order_count'))
            ->join('orders', 'users.id', '=', 'orders.user_id')
            ->whereNotNull('department')
            ->groupBy('department')
            ->orderBy('order_count', 'desc')
            ->get();
        
        // Top Ordered Products
        $topProducts = Product::select('products.*', DB::raw('SUM(order_items.quantity) as total_ordered'))
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->groupBy('products.id')
            ->orderBy('total_ordered', 'desc')
            ->limit(10)
            ->get();
        
        // Status-wise Orders
        $statusOrders = Order::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();
        
        // Chart Data for Orders Per Month
        $chartLabels = $monthlyOrders->pluck('month')->reverse()->toArray();
        $chartData = $monthlyOrders->pluck('total_orders')->reverse()->toArray();
        
        // Chart Data for Status Distribution
        $statusLabels = $statusOrders->pluck('status')->map(function($status) {
            return ucfirst($status);
        })->toArray();
        $statusData = $statusOrders->pluck('count')->toArray();
        
        return view('admin.reports.index', compact(
            'monthlyOrders',
            'departmentOrders',
            'topProducts',
            'statusOrders',
            'chartLabels',
            'chartData',
            'statusLabels',
            'statusData'
        ));
    }
}
