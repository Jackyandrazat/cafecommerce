<!DOCTYPE html>
<html>
<head>
    <title>Laporan Bulanan</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        h2 {
            text-align: center;
        }
    </style>
</head>
<body>
    <h2>Laporan Bulanan ({{ $startDate->format('F Y') }})</h2>
    <p><strong>Total Pendapatan:</strong> {{ number_format($totalRevenue, 0, ',', '.') }} IDR</p>
    <p><strong>Pesanan Selesai:</strong> {{ $completedOrders }}</p>
    <p><strong>Pesanan Pending:</strong> {{ $pendingOrders }}</p>

    <h3>Rincian Pesanan</h3>
    <table>
        <thead>
            <tr>
                <th>ID Pesanan</th>
                <th>Nama Pelanggan</th>
                <th>Total Harga</th>
                <th>Metode Pembayaran</th>
                <th>Status</th>
                <th>Tanggal Pemesanan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->customer_name }}</td>
                    <td>{{ number_format($order->total_price, 0, ',', '.') }} IDR</td>
                    <td>{{ $order->payment_method }}</td>
                    <td>{{ ucfirst($order->status) }}</td>
                    <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
