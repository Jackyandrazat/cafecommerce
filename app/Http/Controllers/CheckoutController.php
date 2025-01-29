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
        $promoId = session('applied_promo', null);
        $promo   = null;
        if ($promoId) {
            $promo = Promo::find($promoId);

            // Double check: is_active, is_expired
            if (!$promo || !$promo->is_active || $promo->is_expired) {
                session()->forget('applied_promo');
                throw ValidationException::withMessages([
                    'promo' => 'Promo sudah tidak berlaku.',
                ]);
            }

            // Jika OK, terapkan diskon
            if ($promo->type === 'percentage') {
                $discount = $total * ($promo->value / 100);
            } else { // 'nominal'
                $discount = $promo->value;
            }

            // Pastikan diskon tidak melebihi total
            $discount = min($discount, $total);

            $total -= $discount;
        }

        return Inertia::render('Checkout/index', [
            'cart' => $cartItems,
            'total' => $total,
            'promo' => $promo->value, // Promo yang diterapkan
        ]);
    }


    /**
     * Menerapkan kode promo.
     */
    public function applyPromo(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $code = $request->input('code');
        $promo = Promo::where('code', $code)->first();

        // 1) Promo ada?
        if (!$promo) {
            // return back()->withErrors(['promo' => 'Kode promo tidak ditemukan.']);
            throw ValidationException::withMessages([
                'promo' => 'Kode promo tidak ditemukan.',
            ]);
        }

        // 2) Cek is_active
        if (!$promo->is_active) {
            // return back()->withErrors(['promo' => 'Promo ini tidak aktif.']);
            throw ValidationException::withMessages([
                'promo' => 'Promo ini tidak aktif.',
            ]);
        }

        // 3) Cek kadaluarsa atau belum mulai
        if ($promo->is_expired || !$promo->is_started) {
            throw ValidationException::withMessages([
                'promo' => 'Promo sudah kadaluarsa atau belum dimulai.',
            ]);
            // return back()->withErrors(['promo' => 'Promo sudah kadaluarsa atau belum dimulai.']);
        }

        // 4) (Opsional) Cek apakah user sudah pernah pakai, dsb.
        //    - Biasanya kita simpan data di promo_user (pivot) atau di orders.

        // Lolos semua, taruh di session agar bisa diaplikasikan saat checkout
        session()->put('applied_promo', $promo->id);

        return back()->with('success', 'Promo berhasil diterapkan!');
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
        $promoId = session('applied_promo', null);
        $promo   = null;
        if ($promoId) {
            $promo = Promo::find($promoId);

            // Double check: is_active, is_expired
            if (!$promo || !$promo->is_active || $promo->is_expired) {
                session()->forget('applied_promo');
                throw ValidationException::withMessages([
                    'promo' => 'Promo sudah tidak berlaku.',
                ]);
            }

            // Jika OK, terapkan diskon
            if ($promo->type === 'percentage') {
                $discount = $total * ($promo->value / 100);
            } else { // 'nominal'
                $discount = $promo->value;
            }

            // Pastikan diskon tidak melebihi total
            $discount = min($discount, $total);

            $total -= $discount;
        }

        // Pastikan user terautentikasi sebelum membuat pesanan
        $customerName = Auth::check() ? Auth::user()->name : 'Guest';
        $isUsed = Order::where('customer_name', $customerName)
        ->where('promo_id', $promo->id)
        ->exists();

        if ($isUsed) {
            throw ValidationException::withMessages([
                'promo' => 'Anda sudah pernah menggunakan promo ini.',
            ]);
        }

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
            'promo_id' => $promo->id,
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

        session()->forget('applied_promo');

        // Hapus item keranjang setelah pesanan dibuat
        CartItem::where('user_id', Auth::id())
            ->orWhere('session_id', session()->getId())
            ->delete();

        // Hapus promo dari session
        session()->forget('promo');

        return redirect()->route('home')->with('success', 'Pesanan berhasil dibuat!');
    }


}
