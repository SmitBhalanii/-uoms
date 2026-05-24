<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * Display user's wishlist.
     */
    public function index()
    {
        $wishlists = auth()->user()
            ->wishlists()
            ->with('product.category', 'product.unit')
            ->latest()
            ->paginate(10);
        
        return view('user.wishlist.index', compact('wishlists'));
    }
    
    /**
     * Add product to wishlist.
     */
    public function add(Product $product)
    {
        $user = auth()->user();
        
        // Check if already in wishlist
        if ($user->hasInWishlist($product->id)) {
            return back()->with('info', 'Product already in wishlist.');
        }
        
        Wishlist::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
        
        return back()->with('success', 'Product added to wishlist.');
    }
    
    /**
     * Remove product from wishlist.
     */
    public function remove(Wishlist $wishlist)
    {
        // Ensure user owns this wishlist item
        if ($wishlist->user_id !== auth()->id()) {
            abort(403);
        }
        
        $wishlist->delete();
        
        return back()->with('success', 'Product removed from wishlist.');
    }
}
