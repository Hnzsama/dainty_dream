<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display all products.
     */
    public function index(Request $request): View
    {
        $query = Product::with('category', 'supplier');
        
        if ($request->has('search') && $request->get('search') !== '') {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhereHas('category', function($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('supplier', function($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%");
                  });
            });
        }
        
        $products = $query->paginate(5)->appends(request()->query());
        $categories = \App\Models\Category::all();
        $suppliers = \App\Models\Supplier::all();
        return view('products.index', ['products' => $products, 'categories' => $categories, 'suppliers' => $suppliers]);
    }

    /**
     * Show create form.
     */
    public function create(): View
    {
        $categories = \App\Models\Category::all();
        $suppliers = \App\Models\Supplier::all();
        return view('products.create', ['categories' => $categories, 'suppliers' => $suppliers]);
    }

    /**
     * Store product.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'supplier_id' => 'required',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        Product::create($request->only(['name', 'category_id', 'supplier_id', 'price', 'stock']));
        return redirect('/products')->with('msg', 'Product added!');
    }

    /**
     * Show edit form.
     */
    public function edit(Product $product): View
    {
        $categories = \App\Models\Category::all();
        $suppliers = \App\Models\Supplier::all();
        return view('products.edit', ['product' => $product, 'categories' => $categories, 'suppliers' => $suppliers]);
    }

    /**
     * Update product.
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'supplier_id' => 'required',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $product->update($request->only(['name', 'category_id', 'supplier_id', 'price', 'stock']));
        return redirect('/products')->with('msg', 'Product updated!');
    }

    /**
     * Delete product.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();
        return redirect('/products')->with('msg', 'Product deleted!');
    }
}
