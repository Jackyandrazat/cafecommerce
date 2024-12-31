<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Promo;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        return inertia('Checkout', ['cart' => $cart]);
    }

    public function applyPromo(Request $request)
    {
        $promo = Promo::where('code', $request->promo_code)->first();

        if (!$promo || !$promo->is_active || now()->greaterThan($promo->expires_at)) {
            return back()->with('error', 'Kode promo tidak valid atau sudah kedaluwarsa.');
        }

        session(['promo' => $promo]);
        return back()->with('success', 'Kode promo berhasil diterapkan!');
    }

    public function process(Request $request)
    {
        $cart = session('cart', []);
        $promo = session('promo', null);

        $total = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));
        if ($promo) {
            $total -= $promo->discount_amount;
        }

        $order = Order::create([
            'customer_name' => auth()->user()->name,
            'products' => json_encode($cart),
            'total_price' => $total,
            'payment_method' => $request->payment_method,
            'status' => 'pending',
        ]);

        session()->forget(['cart', 'promo']);

        return redirect()->route('landing.page')->with('success', 'Pesanan berhasil dibuat!');
    }
}
