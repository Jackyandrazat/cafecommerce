<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pesanan</title>
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
    </style>
</head>
<body>
    <h2>Laporan Pesanan</h2>
    <p><strong>Nama Pelanggan:</strong> {{ $order->customer_name }}</p>
    <p><strong>Total Harga:</strong> {{ number_format($order->total_price, 0, ',', '.') }} IDR</p>
    <p><strong>Metode Pembayaran:</strong> {{ $order->payment_method }}</p>
    <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
    <p><strong>Tanggal Pemesanan:</strong> {{ $order->created_at->format('d M Y H:i') }}</p>

    <h3>Daftar Produk</h3>
    <table>
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Jumlah</th>
                <th>Harga</th>
            </tr>
        </thead>
        <tbody>
            @if(!empty($orderProducts) && count($orderProducts) > 0)
                @foreach ($orderProducts as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>1</td> <!-- Jika jumlah tidak ada di tabel order_product -->
                        <td>{{ number_format($product->price, 0, ',', '.') }} IDR</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="3" style="text-align: center;">Tidak ada produk yang terkait dengan pesanan ini.</td>
                </tr>
            @endif
        </tbody>
    </table>
</body>
</html>
