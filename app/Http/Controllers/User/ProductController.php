<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index(Request $request)
    {
        $query = Product::active()
            ->with(['category', 'brand']);
        
        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('product_name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }
        
        // Filter by category
        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }
        
        $products = $query->paginate(12);
        $categories = Category::active()->get();
        
        return view('user.products.index', compact('products', 'categories'));
    }
    
    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        $product->load(['category', 'brand']);
        $relatedProducts = Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with(['brand'])
            ->take(4)
            ->get();
        
        return view('user.products.show', compact('product', 'relatedProducts'));
    }
}
