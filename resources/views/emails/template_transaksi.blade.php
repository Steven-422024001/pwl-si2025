<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Transaksi</title>
    <style>
        /* * CSS ini ditaruh di <head> agar kompatibel dengan 
         * sebagian besar klien email seperti Gmail.
         */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f6f6f6;
            color: #333;
        }
        .container {
            width: 90%;
            max-width: 600px;
            margin: 20px auto;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            background-color: #ffffff;
        }
        .header {
            background-color: #4A90E2; /* Anda bisa ganti warna ini */
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            color: #ffffff;
            font-size: 24px;
        }
        .content {
            padding: 30px;
        }
        .content p {
            line-height: 1.6;
            font-size: 16px;
        }
        .info-box {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
            font-size: 14px;
        }
        .info-box strong {
            display: inline-block;
            width: 120px; /* Agar rapi */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border-bottom: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
            font-size: 14px;
        }
        td {
            font-size: 15px;
        }
        .total-row {
            font-size: 18px;
            font-weight: bold;
        }
        .total-row td {
            border-bottom: none; /* Hapus garis di baris total */
        }
        .footer {
            background-color: #f4f4f4;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Mofu Cafe</h1>
        </div>

        <div class="content">
            <p>Hai <strong>{{ $transaksi->nama_pembeli }}</strong>,</p>
            <p>Terima kasih atas pembelian Anda. Ini adalah rincian untuk transaksi Anda:</p>

            <div class="info-box">
                <strong>ID Transaksi:</strong> #{{ $transaksi->id }} <br>
                <strong>Tanggal:</strong> {{ $transaksi->created_at->format('d M Y, H:i') }} <br>
                <strong>Kasir:</strong> {{ $transaksi->nama_kasir }} <br>
                <strong>Metode Bayar:</strong> {{ $transaksi->metode_pembayaran }}
            </div>

            <h3>Detail Barang</h3>
            <table>
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th style="text-align: right;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($details as $item)
                        <tr>
                            <td>{{ $item->id_product }}</td> 
                            <td>{{ $item->jumlah_pembelian }}</td>
                            <td style="text-align: right;">Rp {{ number_format($item->subtotal_harga, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                    
                    <tr class="total-row">
                        <td colspan="2" style="text-align: right;">Grand Total:</td>
                        <td style="text-align: right;">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Mofu Cafe. Semua hak cipta dilindungi.</p>
        </div>
    </div>
</body>
</html>