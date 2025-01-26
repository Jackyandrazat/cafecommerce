<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Order;
use App\Models\Promo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

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

        $cart = session('cart', []);
        $promo = session('promo', null);

        // Jika keranjang kosong
        if (empty($cart)) {
            return back()->with('error', 'Keranjang belanja kosong.');
        }

        // Hitung total harga
        $total = array_sum(array_map(fn ($item) => $item['price'] * $item['quantity'], $cart));

        // Jika ada promo, kurangi total dengan diskon
        if ($promo) {
            $total -= $promo->discount_amount;
        }

        // Pastikan user terautentikasi sebelum membuat pesanan
        $customerName = Auth::check() ? Auth::user()->name : 'Guest';

        // Buat order baru
        $order = Order::create([
            'customer_name' => $customerName,
            'products' => json_encode($cart), // Simpan produk dalam format JSON
            'total_price' => $total,
            'payment_method' => $request->payment_method,
            'status' => 'pending', // Status awal pesanan
        ]);

        // Kosongkan session keranjang dan promo
        session()->forget(['cart', 'promo']);

        return redirect()->route('landing.page')->with('success', 'Pesanan berhasil dibuat!');
    }
}
