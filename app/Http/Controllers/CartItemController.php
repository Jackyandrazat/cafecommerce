<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Product;
use App\Models\CartItem;
use App\Http\Requests\StoreCartItemRequest;
use App\Http\Requests\UpdateCartItemRequest;
use Illuminate\Support\Facades\Auth;

class CartItemController extends Controller
{
    /**
     * Display a listing of the resource (Cart Items).
     */
    public function index()
    {
        $cartItems = CartItem::with('product')
            ->where('user_id', auth()->id())
            ->orWhere('session_id', session()->getId())
            ->get();

        $total = $cartItems->sum(fn ($item) => $item->quantity * $item->price);

        return Inertia::render('Cart/index', [
            'cartItems' => $cartItems,
            'total' => $total,
        ]);
    }

    /**
     * Store a newly created cart item in storage.
     */
    public function store(StoreCartItemRequest $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Anda harus login untuk menambahkan produk ke keranjang.');
        }

        $product = Product::findOrFail($request->product_id);

        if ($product->stock < $request->quantity) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi.');
        }
        
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

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }



    /**
     * Update the specified cart item in storage.
     */
    public function update(UpdateCartItemRequest $request, CartItem $cartItem)
    {
        $cartItem->update([
            'quantity' => $request->quantity,
        ]);

        return redirect()->route('cart.index')->with('success', 'Jumlah produk diperbarui.');
    }

    /**
     * Remove the specified cart item from storage.
     */
    public function destroy(CartItem $cartItem)
    {
        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Produk dihapus dari keranjang.');
    }
}
