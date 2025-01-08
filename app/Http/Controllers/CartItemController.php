<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreCartItemRequest;
use App\Http\Requests\UpdateCartItemRequest;

class CartItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cartItems = CartItem::with('product')
            ->where('user_id', Auth::id())
            ->orWhere('session_id', session()->getId())
            ->get();

        return Inertia::render('Cart/index', [
            'cartItems' => $cartItems,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCartItemRequest $request)
    {
        $product = Product::findOrFail($request->product_id);

        $cartItem = CartItem::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'session_id' => session()->getId(),
                'product_id' => $product->id,
            ],
            [
                'quantity' => $request->quantity ?? 1,
                'price' => $product->price,
            ]
        );

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CartItem $cartItem)
    {
        return Inertia::render('Cart/Show', [
            'cartItem' => $cartItem->load('product'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CartItem $cartItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCartItemRequest $request, CartItem $cartItem)
    {
        $cartItem->update([
            'quantity' => $request->quantity,
        ]);

        return redirect()->route('cart.index')->with('success', 'Jumlah produk diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CartItem $cartItem)
    {
        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Produk dihapus dari keranjang.');
    }
}
