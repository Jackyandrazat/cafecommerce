<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Order;
use App\Models\Promo;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    /**
     * Menampilkan halaman checkout.
     */
    public function index()
    {
        // Ambil data keranjang dari database berdasarkan user_id atau session_id
        $cartItems = CartItem::with('product')
            ->where('user_id', auth()->id())
            ->orWhere('session_id', session()->getId())
            ->get();

        // Jika keranjang kosong, arahkan kembali ke halaman keranjang
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong.');
        }

        // Hitung total harga berdasarkan data keranjang
        $total = $cartItems->sum(fn ($item) => $item->quantity * $item->price);

        return Inertia::render('Checkout/index', [
            'cart' => $cartItems,
            'total' => $total,
            'promo' => session('promo', null), // Promo yang diterapkan
        ]);
    }


    /**
     * Menerapkan kode promo.
     */
    public function applyPromo(Request $request)
    {
        $request->validate([
            'promo_code' => 'required|string',
        ]);

        $promo = Promo::where('code', $request->promo_code)->first();

        if (!$promo || !$promo->is_active || now()->greaterThan($promo->expires_at)) {
            return back()->with('error', 'Kode promo tidak valid atau sudah kedaluwarsa.');
        }

        // Simpan promo ke dalam session
        session(['promo' => $promo]);

        return back()->with('success', 'Kode promo berhasil diterapkan!');
    }

    /**
     * Memproses checkout.
     */
    public function process(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:cod,qris,midtrans',
        ]);

        // Ambil data keranjang dari database (bukan session)
        $cartItems = CartItem::where('user_id', Auth::id())
            ->orWhere('session_id', session()->getId())
            ->get();

        // Jika keranjang kosong
        if ($cartItems->isEmpty()) {
            // Lempar exception validasi jika keranjang kosong
            throw ValidationException::withMessages([
                'cart' => 'Keranjang belanja kosong.',
            ]);
        }

        // Contoh ambil stok langsung
        $productIds = $cartItems->pluck('product_id');
        $products   = Product::whereIn('id', $productIds)->get();

        foreach ($products as $product) {
            $cartItem = $cartItems->firstWhere('product_id', $product->id);
            if ($cartItem->quantity > $product->stock) {
                // Lempar ValidationException
                throw ValidationException::withMessages([
                    'stock' => 'Stok produk ' . $product->name . ' tidak mencukupi.',
                ]);
            }
        }

        // Hitung total harga
        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item->quantity * $item->price;
        }

        // Ambil promo jika ada
        $promo = session('promo', null);
        if ($promo) {
            $total -= $promo->discount_amount;
        }

        // Pastikan user terautentikasi sebelum membuat pesanan
        $customerName = Auth::check() ? Auth::user()->name : 'Guest';

        // Simpan order ke database
        $order = Order::create([
            'customer_name'  => $customerName,
            'products'       => $cartItems->map(function ($item) {
                return [
                    'name'     => $item->product->name ?? '',
                    'price'    => $item->price,
                    'quantity' => $item->quantity,
                ];
            })->toJson(),
            'total_price'    => $total,
            'payment_method' => $request->payment_method,
            'status'         => 'pending',
        ]);

        // Update stok produk di database setelah pemesanan berhasil
        foreach ($products as $product) {
            $cartItem = $cartItems->firstWhere('product_id', $product->id);
            if ($cartItem) {
                $product->stock -= $cartItem->quantity;
                $product->save();
            }
        }

        // Hapus item keranjang setelah pesanan dibuat
        CartItem::where('user_id', Auth::id())
            ->orWhere('session_id', session()->getId())
            ->delete();

        // Hapus promo dari session
        session()->forget('promo');

        return redirect()->route('home')->with('success', 'Pesanan berhasil dibuat!');
    }


}
