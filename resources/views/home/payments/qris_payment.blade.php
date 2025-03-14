<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran QRIS</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f9f9f9;
        }

        .container {
            max-width: 400px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        img {
            width: 150px;
            margin-bottom: 20px;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            font-size: 16px;
            color: #fff;
            background-color: #FF6600;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
        }

        .button:hover {
            background-color: #CC5500;
        }

        .user-center input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .user-center input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
    <script>
        function downloadQR() {
            // Get the QR image URL from your data
            const qrImageUrl = '{{ url('/payment/qris/download?imgUrl=') . $data['qrUrl'] }}';

            // Create a temporary anchor element
            const downloadLink = document.createElement('a');
            downloadLink.href = qrImageUrl;
            downloadLink.download = 'QRIS_payment.png'; // Name for the downloaded file

            // Append to the body, trigger click, and remove
            document.body.appendChild(downloadLink);
            downloadLink.click();
            document.body.removeChild(downloadLink);
        }
    </script>
</head>

<body>
    <div class="container">
        <img src="{{ $data['qrUrl'] }}" alt="Logo qris">
        <h2>Pembayaran Melalui QRIS</h2>
        <p>Silakan ikuti langkah-langkah berikut untuk melakukan pembayaran menggunakan QRIS:</p>
        <ol style="text-align: left;">
            <li>Buka aplikasi mobile banking atau e-wallet yang mendukung QRIS.</li>
            <li>Pindai kode QR yang telah disediakan.</li>
            <li>Masukkan nominal pembayaran sebesar: <strong>Rp {{ number_format($amount, 2, ',', '.') }}</strong></li>
            <li>Konfirmasi pembayaran dan selesaikan transaksi.</li>
            <li>Simpan bukti pembayaran untuk referensi.</li>
        </ol>
        <p>Tenggat waktu pembayaran: {{ now()->addHours(3)->diffForHumans() }}</p>
        <div class="user-center">
            <button class="button" onclick="downloadQR()">Download QR</button>
        </div>
    </div>
</body>

</html>
