<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::query()
            ->when(
                $request->search,
                fn($query) =>
                $query->where('name', 'like', "%{$request->search}%")
            )
            ->when(
                $request->category,
                fn($query) =>
                $query->where('category_id', $request->category)
            )
            ->paginate(10)
            ->withQueryString(); // Menyimpan parameter query untuk pagination

        return Inertia::render('Products/productIndex', [
            'products' => $products,
            'filters' => $request->only(['search', 'category'])
        ]);
    }
    public function show($id)
    {
        $product = Product::findOrFail($id);

        return Inertia::render('Products/detail', [
            'product' => $product
        ]);
    }
}
