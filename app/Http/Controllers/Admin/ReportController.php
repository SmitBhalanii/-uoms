<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /**
     * Display reports dashboard with charts and analytics.
     */
    public function index(Request $request)
    {
        try {
            // Monthly Orders Report
            $monthlyOrders = Order::select(
                    DB::raw('strftime("%Y-%m", created_at) as month'),
                    DB::raw('COUNT(*) as total_orders'),
                    DB::raw('SUM(total_items) as total_items')
                )
                ->groupBy('month')
                ->orderBy('month', 'desc')
                ->limit(12)
                ->get();
            
            // Top Ordered Products
            $topProducts = Product::select('products.*', DB::raw('COALESCE(SUM(order_items.quantity), 0) as total_ordered'))
                ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
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
                'topProducts',
                'statusOrders',
                'chartLabels',
                'chartData',
                'statusLabels',
                'statusData'
            ));
        } catch (\Exception $e) {
            return view('admin.reports.index', [
                'monthlyOrders' => collect([]),
                'topProducts' => collect([]),
                'statusOrders' => collect([]),
                'chartLabels' => [],
                'chartData' => [],
                'statusLabels' => [],
                'statusData' => [],
                'error' => 'Unable to load reports. Please try again later.'
            ]);
        }
    }

    /**
     * Display order calendar.
     */
    public function calendar(Request $request)
    {
        $orders = Order::with('user')->get();
        
        // Format orders for FullCalendar
        $events = $orders->map(function($order) {
            $color = match($order->status) {
                'pending' => '#ffc107',
                'processing' => '#17a2b8',
                'approved' => '#3498db',
                'rejected' => '#dc3545',
                'completed' => '#28a745',
                default => '#6c757d',
            };
            
            return [
                'id' => $order->id,
                'title' => $order->order_number,
                'start' => $order->created_at->format('Y-m-d'),
                'backgroundColor' => $color,
                'borderColor' => $color,
                'extendedProps' => [
                    'order_number' => $order->order_number,
                    'user' => $order->user->name,
                    'department' => $order->user->department ?? 'N/A',
                    'status' => ucfirst($order->status),
                    'total_items' => $order->total_items,
                ]
            ];
        });
        
        return view('admin.reports.calendar', compact('events'));
    }

    /**
     * Generate monthly report.
     */
    public function monthlyReport(Request $request)
    {
        $request->validate([
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2020|max:' . (date('Y') + 1),
        ]);

        $month = $request->month;
        $year = $request->year;
        
        $orders = Order::with('user', 'orderItems.product')
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->get();
        
        $totalOrders = $orders->count();
        $totalQuantity = $orders->sum('total_items');
        $totalProducts = $orders->flatMap->orderItems->pluck('product_id')->unique()->count();
        
        $statusSummary = $orders->groupBy('status')->map->count();
        
        $data = compact('month', 'year', 'orders', 'totalOrders', 'totalQuantity', 'totalProducts', 'statusSummary');
        
        if ($request->has('export') && $request->export == 'pdf') {
            return $this->exportMonthlyPDF($data);
        }
        
        return view('admin.reports.monthly', $data);
    }

    /**
     * Generate custom date report.
     */
    public function customReport(Request $request)
    {
        $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
        ]);

        $fromDate = $request->from_date;
        $toDate = $request->to_date;
        
        $orders = Order::with('user', 'orderItems.product')
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->get();
        
        $totalOrders = $orders->count();
        $totalQuantity = $orders->sum('total_items');
        $totalProducts = $orders->flatMap->orderItems->pluck('product_id')->unique()->count();
        
        $statusSummary = $orders->groupBy('status')->map->count();
        
        $data = compact('fromDate', 'toDate', 'orders', 'totalOrders', 'totalQuantity', 'totalProducts', 'statusSummary');
        
        if ($request->has('export') && $request->export == 'pdf') {
            return $this->exportCustomPDF($data);
        }
        
        return view('admin.reports.custom', $data);
    }

    /**
     * Generate highest selling products report.
     */
    public function topProductsReport(Request $request)
    {
        $topProducts = Product::with('brand', 'category')
            ->select('products.*', DB::raw('COALESCE(SUM(order_items.quantity), 0) as total_ordered'))
            ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
            ->groupBy('products.id')
            ->orderBy('total_ordered', 'desc')
            ->limit(10)
            ->get();
        
        $data = compact('topProducts');
        
        if ($request->has('export') && $request->export == 'pdf') {
            return $this->exportTopProductsPDF($data);
        }
        
        return view('admin.reports.top-products', $data);
    }

    /**
     * Generate status-wise report.
     */
    public function statusReport(Request $request, $status)
    {
        $validStatuses = ['pending', 'processing', 'approved', 'rejected', 'completed'];
        
        if (!in_array($status, $validStatuses)) {
            abort(404);
        }
        
        $orders = Order::with('user', 'orderItems.product')
            ->where('status', $status)
            ->get();
        
        $totalOrders = $orders->count();
        $totalQuantity = $orders->sum('total_items');
        
        $data = compact('status', 'orders', 'totalOrders', 'totalQuantity');
        
        if ($request->has('export') && $request->export == 'pdf') {
            return $this->exportStatusPDF($data);
        }
        
        return view('admin.reports.status', $data);
    }

    /**
     * Generate low stock products report.
     */
    public function lowStockReport(Request $request)
    {
        $lowStockProducts = Product::with('brand', 'category')
            ->where('stock_quantity', '<=', 10)
            ->where('status', 1)
            ->orderBy('stock_quantity', 'asc')
            ->get();
        
        $data = compact('lowStockProducts');
        
        if ($request->has('export') && $request->export == 'pdf') {
            return $this->exportLowStockPDF($data);
        }
        
        return view('admin.reports.low-stock', $data);
    }

    /**
     * Export monthly report to PDF.
     */
    private function exportMonthlyPDF($data)
    {
        $pdf = PDF::loadView('admin.reports.pdf.monthly', $data);
        $pdf->setPaper('A4', 'portrait');
        
        $monthName = date('F', mktime(0, 0, 0, $data['month'], 1));
        $filename = "Monthly_Report_{$monthName}_{$data['year']}.pdf";
        
        return $pdf->download($filename);
    }

    /**
     * Export custom date report to PDF.
     */
    private function exportCustomPDF($data)
    {
        $pdf = PDF::loadView('admin.reports.pdf.custom', $data);
        $pdf->setPaper('A4', 'portrait');
        
        $filename = "Custom_Report_{$data['fromDate']}_to_{$data['toDate']}.pdf";
        
        return $pdf->download($filename);
    }

    /**
     * Export top products report to PDF.
     */
    private function exportTopProductsPDF($data)
    {
        $pdf = PDF::loadView('admin.reports.pdf.top-products', $data);
        $pdf->setPaper('A4', 'portrait');
        
        $filename = "Top_Products_Report_" . date('Y-m-d') . ".pdf";
        
        return $pdf->download($filename);
    }

    /**
     * Export status report to PDF.
     */
    private function exportStatusPDF($data)
    {
        $pdf = PDF::loadView('admin.reports.pdf.status', $data);
        $pdf->setPaper('A4', 'portrait');
        
        $filename = ucfirst($data['status']) . "_Orders_Report_" . date('Y-m-d') . ".pdf";
        
        return $pdf->download($filename);
    }

    /**
     * Export low stock report to PDF.
     */
    private function exportLowStockPDF($data)
    {
        $pdf = PDF::loadView('admin.reports.pdf.low-stock', $data);
        $pdf->setPaper('A4', 'portrait');
        
        $filename = "Low_Stock_Products_Report_" . date('Y-m-d') . ".pdf";
        
        return $pdf->download($filename);
    }
}
