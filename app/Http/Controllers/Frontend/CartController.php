<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        return inertia('Cart', ['cart' => $cart]);
    }

    public function add(Request $request)
    {
        $cart = session('cart', []);
        $cart[$request->id] = [
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
        ];
        session(['cart' => $cart]);
        return redirect()->route('cart.index');
    }

    public function update(Request $request)
    {
        $cart = session('cart', []);
        if (isset($cart[$request->id])) {
            $cart[$request->id]['quantity'] = $request->quantity;
            session(['cart' => $cart]);
        }
        return redirect()->route('cart.index');
    }

    public function remove(Request $request)
    {
        $cart = session('cart', []);
        unset($cart[$request->id]);
        session(['cart' => $cart]);
        return redirect()->route('cart.index');
    }
}
