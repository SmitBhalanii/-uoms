<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display cart.
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $cartItems = [];
        $totalItems = 0;
        
        foreach ($cart as $productId => $quantity) {
            $product = Product::with('brand', 'category')->find($productId);
            if ($product) {
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                ];
                $totalItems += $quantity;
            }
        }
        
        return view('user.cart.index', compact('cartItems', 'totalItems'));
    }
    
    /**
     * Add product to cart.
     */
    public function add(Product $product)
    {
        // Validate product is active and in stock
        if (!$product->status) {
            return back()->with('error', 'This product is not available.');
        }
        
        if ($product->stock_quantity <= 0) {
            return back()->with('error', 'This product is out of stock.');
        }
        
        $cart = session()->get('cart', []);
        
        // Check if product already in cart
        if (isset($cart[$product->id])) {
            // Check if adding one more exceeds stock
            if ($cart[$product->id] + 1 > $product->stock_quantity) {
                return back()->with('error', 'Cannot add more. Available stock: ' . $product->stock_quantity . ' pieces.');
            }
            $cart[$product->id]++;
        } else {
            $cart[$product->id] = 1;
        }
        
        session()->put('cart', $cart);
        
        return back()->with('success', 'Product added to cart successfully!');
    }
    
    /**
     * Update cart quantity.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);
        
        $product = Product::findOrFail($validated['product_id']);
        
        // Validate quantity
        if ($validated['quantity'] > $product->stock_quantity) {
            return back()->with('error', 'Requested quantity exceeds available stock (' . $product->stock_quantity . ' pieces).');
        }
        
        $cart = session()->get('cart', []);
        $cart[$validated['product_id']] = $validated['quantity'];
        session()->put('cart', $cart);
        
        return back()->with('success', 'Cart updated successfully!');
    }
    
    /**
     * Remove product from cart.
     */
    public function remove(Product $product)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            session()->put('cart', $cart);
            return back()->with('success', 'Product removed from cart.');
        }
        
        return back()->with('error', 'Product not found in cart.');
    }
    
    /**
     * Clear entire cart.
     */
    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', 'Cart cleared successfully!');
    }
}
