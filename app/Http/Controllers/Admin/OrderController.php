<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\OrderStatusUpdated;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    /**
     * Display all orders.
     */
    public function index(Request $request)
    {
        $query = Order::with('user', 'orderItems');
        
        // Search by order number or user name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', '%' . $search . '%');
                  });
            });
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $orders = $query->latest()->paginate(15);
        
        return view('admin.orders.index', compact('orders'));
    }
    
    /**
     * Display the specified order details.
     */
    public function show(Order $order)
    {
        $order->load('user', 'orderItems.product.category', 'orderItems.product.brand');
        
        return view('admin.orders.show', compact('order'));
    }
    
    /**
     * Update order status.
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected,processing,completed',
            'remarks' => 'nullable|string|max:500',
        ]);
        
        // Store old status for email
        $oldStatus = $order->status;
        
        $order->update([
            'status' => $validated['status'],
            'remarks' => $validated['remarks'] ?? $order->remarks,
        ]);
        
        // Load relationships for email
        $order->load('user', 'orderItems.product.category', 'orderItems.product.brand');
        
        // Send email notification if status changed
        if ($oldStatus !== $order->status) {
            Mail::to($order->user->email)->send(new OrderStatusUpdated($order, $oldStatus));
        }
        
        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Order status updated successfully! Email notification sent to user.');
    }
}
