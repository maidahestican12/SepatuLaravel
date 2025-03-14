<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran {{ $data['additionalInfo']['channel'] }}</title>
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
    </style>
    <script>
        window.onload = function startCountdown() {
            let timeLeft = 15 * 60;
            const countdown = document.getElementById("countdown");

            function updateCountdown() {
                let minutes = Math.floor(timeLeft / 60);
                let seconds = timeLeft % 60;
                countdown.textContent = minutes + ":" + (seconds < 10 ? "0" : "") + seconds;

                if (timeLeft <= 0) {
                    clearInterval(timer);
                    window.location.href = "failedPage.html";
                }

                timeLeft--;
            }

            updateCountdown();
            let timer = setInterval(updateCountdown, 1000);
        };
    </script>
</head>

<body>

    <div class="container">
        <img src="{{ url('images/' . strtolower($data['additionalInfo']['channel']) . '.png') }}" alt="Logo BSI">
        <h2>Pembayaran Melalui {{ $data['additionalInfo']['channel'] }}</h2>
        <p>Silakan transfer ke nomor rekening berikut sebelum waktu habis:</p>
        <h3>{{ $data['virtualAccountNo'] }}</h3>
        <p>a.n. {{ $data['virtualAccountName'] }}</p>
        <p>Jumlah:
            <strong>{{ $data['totalAmount']['currency'] . ' ' . number_format($data['totalAmount']['value'], 2, ',', '.') }}</strong>
        </p>
        <p>Tenggat waktu pembayaran: {{ Carbon\Carbon::parse($data['expiredDate'])->diffForHumans() }}</p>
        <a class="button" href={{ url('/payment/check?trxId=' . $data['trxId']) }}>Cek Status Pembayaran</a>
    </div>

</body>

</html>
