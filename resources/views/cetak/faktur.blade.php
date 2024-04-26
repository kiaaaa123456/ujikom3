{{-- <body>
    <h2>Cafe Indomart</h2>
    <h5>Jalan jalan</h5>
    <hr>
    <h5>No. Faktur : {{ $transaksi->id }}</h5>
    <h5>{{ $transaksi->tanggal }}</h5>
    <table border="0">
        <thead>
            <tr>
                <td>Qty</td>
                <td>Item</td>
                <td>Harga</td>
                <td>Total</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksi->detailTransaksi as $item)
                <tr>
                    <td>{{ $item->jumlah }}</td>
                    <td>{{ $item->menu->nama_menu }}</td>
                    <td>{{ number_format($item->menu->harga, 0, ',', '.') }}</td>
                    <td>{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3">Total</td>
                <td>{{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
</body> --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cafe Indomart</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
        }

        .container {
            border: 2px solid #000;
            padding: 10px;
            max-width: 400px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
        }

        .info {
            margin-top: 20px;
        }

        .info h5 {
            margin: 5px 0;
        }

        .items {
            margin-top: 20px;
        }

        .item {
            margin-bottom: 5px;
        }

        .total {
            margin-top: 20px;
            text-align: right;
        }

        hr {
            border: 0;
            border-top: 1px solid #000;
            margin: 20px 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>Cafe Indomart</h2>
            <h5>Jalan jalan</h5>
            <hr>
            <h5>No. Faktur : {{ $transaksi->id }}</h5>
            <h5>{{ $transaksi->tanggal }}</h5>
        </div>

        <div class="info">
            <h4>Detail Transaksi:</h4>
            @foreach ($transaksi->DetailTransaksi as $item)
                <div class="item">
                    <p>{{ $item->jumlah }}x {{ $item->menu->nama_menu }}</p>
                    <p>Harga: {{ number_format($item->menu->harga, 0, ',', '.') }}</p>
                    <p>Subtotal: {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                </div>
            @endforeach
        </div>

        <div class="total">
            <p>Total: {{ number_format($transaksi->total_harga, 0, ',', '.') }}</p>
        </div>
    </div>
</body>

</html>
