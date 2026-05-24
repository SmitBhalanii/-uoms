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
     * Display user's orders (Order History).
     */
    public function index(Request $request)
    {
        $query = auth()->user()->orders()->with('orderItems.product');
        
        // Search by order number
        if ($request->filled('search')) {
            $query->where('order_number', 'like', '%' . $request->search . '%');
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $orders = $query->latest()->paginate(10);
        
        return view('user.orders.index', compact('orders'));
    }
    
    /**
     * Show the form for creating a new order (from wishlist).
     */
    public function create()
    {
        $wishlistItems = auth()->user()
            ->wishlists()
            ->with('product.category', 'product.unit')
            ->get();
        
        if ($wishlistItems->isEmpty()) {
            return redirect()->route('user.wishlist.index')
                ->with('error', 'Your wishlist is empty. Add products first.');
        }
        
        return view('user.orders.create', compact('wishlistItems'));
    }
    
    /**
     * Store a newly created order from wishlist.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'quantities' => 'required|array|min:1',
            'quantities.*' => 'required|integer|min:1',
            'remarks' => 'nullable|string|max:500',
        ]);
        
        // Validate stock availability
        foreach ($validated['quantities'] as $productId => $quantity) {
            $product = Product::find($productId);
            if (!$product) {
                return back()->with('error', 'Product not found.');
            }
            if ($quantity > $product->stock_quantity) {
                return back()->with('error', "Quantity for {$product->product_name} exceeds available stock ({$product->stock_quantity}).");
            }
        }
        
        DB::beginTransaction();
        try {
            // Calculate total items
            $totalItems = array_sum($validated['quantities']);
            
            // Create order
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => Order::generateOrderNumber(),
                'total_items' => $totalItems,
                'status' => 'pending',
                'remarks' => $request->remarks,
            ]);
            
            // Create order items
            foreach ($validated['quantities'] as $productId => $quantity) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                ]);
            }
            
            // Clear wishlist
            auth()->user()->wishlists()->delete();
            
            DB::commit();
            
            return redirect()->route('user.orders.index')
                ->with('success', 'Order placed successfully!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to place order. Please try again.');
        }
    }
    
    /**
     * Display the specified order (Order Details).
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
