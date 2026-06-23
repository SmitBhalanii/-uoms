<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\OrderPlaced;
use App\Mail\OrderPlacedAdmin;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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
     * Place order from cart.
     */
    public function placeOrder(Request $request)
    {
        $validated = $request->validate([
            'remarks' => 'nullable|string|max:500',
        ]);
        
        // Get cart from session
        $cart = session()->get('cart', []);
        
        // Validation 1: Cart cannot be empty
        if (empty($cart)) {
            return redirect()->route('user.cart.index')
                ->with('error', 'Cart cannot be empty. Please add products to cart before placing an order.');
        }
        
        // Validation 2: Check all products and quantities
        $errors = [];
        $validatedCart = [];
        
        foreach ($cart as $productId => $quantity) {
            $product = Product::find($productId);
            
            // Validate product exists
            if (!$product) {
                $errors[] = "Product with ID {$productId} not found.";
                continue;
            }
            
            // Validate product is active
            if (!$product->status) {
                $errors[] = "{$product->product_name} is no longer available.";
                continue;
            }
            
            // Validate quantity > 0
            if ($quantity <= 0) {
                $errors[] = "Quantity for {$product->product_name} must be greater than zero.";
                continue;
            }
            
            // Validate stock availability
            if ($quantity > $product->stock_quantity) {
                $errors[] = "Requested quantity for {$product->product_name} ({$quantity}) exceeds available stock ({$product->stock_quantity}).";
                continue;
            }
            
            $validatedCart[$productId] = [
                'product' => $product,
                'quantity' => $quantity,
            ];
        }
        
        // If there are validation errors, return with errors
        if (!empty($errors)) {
            return redirect()->route('user.cart.index')
                ->with('error', 'Order validation failed: ' . implode(' ', $errors));
        }
        
        // If no valid items after validation
        if (empty($validatedCart)) {
            return redirect()->route('user.cart.index')
                ->with('error', 'No valid items in cart. Please check and try again.');
        }
        
        DB::beginTransaction();
        try {
            // Calculate total items
            $totalItems = array_sum(array_column($validatedCart, 'quantity'));
            
            // Create order
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => Order::generateOrderNumber(),
                'total_items' => $totalItems,
                'status' => 'pending',
                'remarks' => $request->remarks,
            ]);
            
            // Create order items
            foreach ($validatedCart as $productId => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'quantity' => $item['quantity'],
                ]);
            }
            
            // Load order relationships for email
            $order->load('orderItems.product.category', 'orderItems.product.brand', 'user');
            
            // Send confirmation email to User
            Mail::to($order->user->email)->send(new OrderPlaced($order));
            
            // Send notification email to Admin
            $adminEmail = env('ADMIN_EMAIL', 'admin@uoms.com');
            Mail::to($adminEmail)->send(new OrderPlacedAdmin($order));
            
            // Clear cart
            session()->forget('cart');
            
            DB::commit();
            
            return redirect()->route('user.orders.show', $order)
                ->with('success', 'Order placed successfully! Confirmation emails have been sent.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Order placement failed: ' . $e->getMessage());
            return redirect()->route('user.cart.index')
                ->with('error', 'Failed to place order. Please try again. Error: ' . $e->getMessage());
        }
    }
    
    /**
     * Display the specified order (Order Details).
     */
    public function show(Order $order)
    {
        // Ensure user owns this order
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this order.');
        }
        
        $order->load('orderItems.product.category', 'orderItems.product.brand');
        
        return view('user.orders.show', compact('order'));
    }
}
