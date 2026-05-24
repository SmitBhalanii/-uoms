<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display user's orders.
     */
    public function index()
    {
        $orders = auth()->user()
            ->orders()
            ->with('orderItems.product')
            ->latest()
            ->paginate(10);
        
        return view('user.orders.index', compact('orders'));
    }
    
    /**
     * Show the form for creating a new order.
     */
    public function create()
    {
        $wishlistItems = auth()->user()
            ->wishlists()
            ->with('product.category', 'product.unit')
            ->get();
        
        return view('user.orders.create', compact('wishlistItems'));
    }
    
    /**
     * Store a newly created order.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.notes' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);
        
        DB::beginTransaction();
        try {
            // Create order
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => Order::generateOrderNumber(),
                'status' => 'pending',
                'notes' => $request->notes,
            ]);
            
            // Create order items
            foreach ($validated['items'] as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'notes' => $item['notes'] ?? null,
                ]);
            }
            
            // Remove items from wishlist if requested
            if ($request->has('remove_from_wishlist')) {
                $productIds = collect($validated['items'])->pluck('product_id');
                auth()->user()->wishlists()->whereIn('product_id', $productIds)->delete();
            }
            
            DB::commit();
            
            return redirect()->route('user.orders.show', $order)
                ->with('success', 'Order placed successfully!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to place order. Please try again.');
        }
    }
    
    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        // Ensure user owns this order
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
        
        $order->load('orderItems.product.category', 'orderItems.product.unit');
        
        return view('user.orders.show', compact('order'));
    }
}
