<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Models\Product;


class ReportController extends Controller
{

    public function generateOrderReport($id)
    {
        $order = Order::findOrFail($id);

        // Ambil produk terkait jika produk disimpan dalam tabel pivot
        $orderProducts = [];
        if ($order->products) {
            $orderProducts = Product::whereIn('id', $order->products)->get();
        }

        $pdf = Pdf::loadView('reports.order', [
            'order' => $order,
            'orderProducts' => $orderProducts,
        ])->setPaper('a4', 'portrait');

        return $pdf->download('order-report-' . $order->id . '-' . now()->format('Y-m-d') . '.pdf');
    }


    public function generateMonthlyReport()
    {
        // Ambil rentang tanggal untuk bulan ini
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        // Ambil pesanan dalam rentang tanggal
        $orders = Order::whereBetween('created_at', [$startDate, $endDate])->get();
        $totalRevenue = $orders->sum('total_price');
        $completedOrders = $orders->where('status', 'completed')->count();
        $pendingOrders = $orders->where('status', 'pending')->count();

        $pdf = Pdf::loadView('reports.monthly', [
            'orders' => $orders,
            'totalRevenue' => $totalRevenue,
            'completedOrders' => $completedOrders,
            'pendingOrders' => $pendingOrders,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ])->setPaper('a4', 'landscape');

        return $pdf->download('monthly-report-' . now()->format('Y-m') . '.pdf');
    }
}
