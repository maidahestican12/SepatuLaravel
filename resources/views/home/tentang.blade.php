@extends('home.templates.index')

@section('page-content')
    <style>
        .product {
            position: relative;
        }

        .sale-label {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: #7988de;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
            font-size: 14px;
            z-index: 10;
            /* Pastikan label muncul di atas gambar */
        }
    </style>

    <br>
    <br>
    <br>
    <br>
    <section class="ftco-section">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-5">
                        <h1 style="color: black; font-weight:bold;">Tentang Kami</h1>
                        <br>
                        <h5 style="color: black; font-weight:bold;">StrideFootwear adalah brand terkemuka yang bergerak di
                            industri sepatu</h5>
                        <p>
                        <p>StrideFootwear adalah e-commerce sepatu terbaik yang menawarkan berbagai koleksi untuk setiap
                            gaya dan aktivitas. Dari sepatu kasual hingga olahraga, formal, dan sneakers eksklusif, kami
                            menghadirkan produk berkualitas tinggi dengan desain trendi dan harga bersaing.

                            Kami berkomitmen untuk memberikan pengalaman belanja online yang mudah, cepat, dan aman dengan
                            berbagai metode pembayaran serta pengiriman cepat ke seluruh Indonesia. Dengan jaminan produk
                            100% original dan layanan pelanggan yang responsif, StrideFootwear memastikan setiap langkah
                            Anda penuh percaya diri dan kenyamanan.

                            Temukan sepatu impian Anda hanya di StrideFootwear – Langkah Lebih Nyaman, Gaya Lebih Percaya
                            Diri! 🚀👟</p>
                        </p>
                    </div>
                </div>

                <div class="col-md-6 d-flex justify-content-center">
                    <img src="{{ asset('foto/bgee.jpg') }}" href="{{ url('home') }}" width="100%">
                </div>
            </div>
        </div>
    </section>
@endsection
