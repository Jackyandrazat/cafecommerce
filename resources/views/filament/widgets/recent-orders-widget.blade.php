<div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow">
    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Pesanan Terbaru</h3>
    <ul>
        @foreach($recentOrders as $order)
            <li>{{ $order->customer_name }} - {{ number_format($order->total_price) }} IDR ({{ $order->status }})</li>
        @endforeach
    </ul>
</div>
