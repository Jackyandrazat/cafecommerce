<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Promo;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $activePromos = Promo::where('is_active', true)->get();

        return inertia('Home', [
            'products' => $products,
            'activePromos' => $activePromos,
        ]);
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return inertia('ProductDetail', ['product' => $product]);
    }
}
