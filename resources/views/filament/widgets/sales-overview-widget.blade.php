<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Total Penjualan Hari Ini</h3>
        <p class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ number_format($totalSalesToday, 0, ',', '.') }} IDR</p>
    </div>
    <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Total Penjualan Minggu Ini</h3>
        <p class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ number_format($totalSalesThisWeek, 0, ',', '.') }} IDR</p>
    </div>
    <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Total Penjualan Bulan Ini</h3>
        <p class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ number_format($totalSalesThisMonth, 0, ',', '.') }} IDR</p>
    </div>
    <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Pesanan Selesai</h3>
        <p class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ $completedOrders }}</p>
    </div>
    <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Pesanan Pending</h3>
        <p class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ $pendingOrders }}</p>
    </div>
</div>
