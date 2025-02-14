@extends('home.templates.index')

@section('page-content')
    <section id="home-section" class="ftco-section">
        <div class="container mt-4">
            <div>
                <div class="card text-center" style="background-color: #7988de;">
                    <p style="color: white;" class="m-auto py-3">
                        {{-- <img src="{{ asset('foto/1a.png') }}" href="{{ url('home') }}" width="20"> Detail Informasi
                        <img src="{{ asset('foto/line.png') }}" href="{{ url('home') }}" width="20">
                        <img src="{{ asset('foto/2b.png') }}" href="{{ url('home') }}" width="20"> Pembayaran
                        <img src="{{ asset('foto/line.png') }}" href="{{ url('home') }}" width="20">
                        <img src="{{ asset('foto/3b.png') }}" href="{{ url('home') }}" width="20"> Konfirmasi --}}
                        Checkout
                    </p>
                </div>
            </div>
            <form method="post" action="{{ url('home/docheckout') }}">
                <?php $totalbelanja = 0; ?>
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="mt-5">
                            <h1 style="color: black; font-weight:bold;">Pesanan Anda</h1>
                        </div>
                        <div class="card py-2 px-2 text-justify">
                            Seluruh pesanan anda yang tercantum adalah harga final tambah biaya tambahan
                            lainnya dan dijamin harga terbaik.
                        </div>
                        <div class="card py-2 px-2 text-justify mt-5">
                            <h3 style="color: black;">Data Kontak Pesan</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nama Pelanggan</label>
                                        <input type="text" value="{{ $pengguna->nama }}" name="nama" required
                                            class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Alamat Email</label>
                                        <input type="text" value="{{ $pengguna->email }}" name="email" required
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>No. Telepon</label>
                                        <input type="text" value="{{ $pengguna->telepon }}" name="telepon" required
                                            class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Alamat Lengkap</label>
                                        <textarea class="form-control" name="alamat" placeholder="Masukkan Alamat" required>{{ $pengguna->alamat }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card py-2 px-2 text-justify mt-5">
                            <h3 style="color: black;">Kebijakan Pemesanan</h3>
                            Dengan melanjutkan ke tahapan selanjutnya, Anda telah membaca dan setuju dengan pihak Seni
                            Relief Kuningan dengan <a href="#" style="color: #7988de;">Syarat & Kententuannya</a>.
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mt-5 py-2 px-2">
                            @foreach (session('keranjang') as $idproduk => $item)
                                @php
                                    $produk = DB::table('produk')->where('idproduk', $idproduk)->first();
                                    $totalharga = $produk->harga * $item['jumlah'];
                                @endphp
                                <h3 style="color: black;">{{ $produk->nama }}</h3>
                                Kota Asal Pengiriman : Kabupaten Jepara
                                <img src="{{ asset('foto/' . $produk->foto) }}" height="250px" alt="">
                            @break
                        @endforeach
                        <p style="color: #7988de; font-weight:600"><img src="{{ asset('foto/location.png') }}"
                                alt=""> Input Lokasi Pengiriman Anda</p>
                        <div class="form-group">
                            <label>Provinsi</label>
                            <select id="province" name="provinsi" class="form-control" required>
                                <option value="">Pilih Provinsi</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kota</label>
                            <select id="city" name="kota" class="form-control" required>
                                <option value="">Pilih Kota</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Ekspedisi</label>
                            <select id="courier" name="courier" class="form-control" required>
                                <option value="">Pilih Ekspedisi</option>
                                <option value="jne">JNE</option>
                                <option value="pos">POS Indonesia</option>
                                <option value="tiki">TIKI</option>
                                <!-- Tambahkan ekspedisi lainnya sesuai kebutuhan -->
                            </select>
                        </div>


                        <div class="form-group">
                            <label>Jenis Pengiriman</label>
                            <select id="service" name="service" class="form-control" required>
                                <option value="">Pilih Jenis Pengiriman</option>
                                <!-- Jenis Pengiriman akan dimuat berdasarkan ekspedisi yang dipilih -->
                            </select>
                        </div>


                        <div class="form-group">
                            <label>Ongkir</label>
                            <input type="text" class="form-control" name="ongkir" required>
                        </div>
                    </div>
                    <div class="card py-2 px-2 text-justify mt-5">
                        <!-- Payment Method Selection -->
                        <div class="form-group mt-3">
                            <label style="color: black;"><strong>Pilih Metode Pembayaran</strong></label><br>
                            <div>
                                <input type="radio" id="transfer" name="metodepembayaran" value="Transfer" required>
                                <label for="transfer">Transfer</label>
                            </div>
                        </div>
                        <h3 style="color: black; font-weight:bold;">Rincian Harga</h3>
                        @if (!empty(session('keranjang')))
                            @foreach (session('keranjang') as $idproduk => $item)
                                @php
                                    $produk = DB::table('produk')->where('idproduk', $idproduk)->first();
                                    $totalharga = $produk->harga * $item['jumlah'];
                                @endphp
                                <div class="row">
                                    <div class="col-md-6">
                                        <p style="color: black;">{{ $produk->nama }} ({{ $item['jumlah'] }} x)</p>
                                        <p style="color: black;">Rp {{ number_format($totalharga) }},-</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p style="color: black;font-weight: bold;" class="text-right">Rp
                                            {{ number_format($produk->harga) }},-</p>
                                    </div>
                                </div>
                                <?php $totalbelanja += $totalharga; ?>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center">Keranjang Kosong</td>
                            </tr>
                        @endif
                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <h5 style="color: black; font-weight:bold;">Total</h5>
                            </div>
                            <div class="col-md-6">
                                <p style="color: black; font-weight:bold;" id="totalHarga" class="text-right">Rp
                                    {{ number_format($totalbelanja) }} <br> <span
                                        style="color: red; font-weight:400;">NON REFUNDABLE</span></p>
                            </div>
                        </div>
                        <hr>
                        <p>Dengan melanjutkan ke tahapan selanjutnya, Anda telah membaca dan setuju dengan pihak Seni
                            Relief Kuningan dengan <a href="#" style="color: #7988de;">Syarat &
                                Kententuannya</a>.</p>



                        <input type="hidden" id="total_belanja" name="total_belanja" value="{{ $totalbelanja }}">
                        <button class="btn btn-lg text-white" style="background-color: #7988de"
                            name="checkout">Lanjutkan Pembayaran</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection

@section('script')
<script>
    // Fetch provinsi saat halaman dimuat
    $.ajax({
        url: '{{ url('home/get-provinces') }}',
        type: 'GET',
        success: function(data) {
            var provinceSelect = $('#province');
            $.each(data, function(index, province) {
                provinceSelect.append(new Option(province.province, province
                    .province_id));
            });
        }
    });

    // Fetch kota berdasarkan provinsi terpilih
    $('#province').change(function() {
        var provinceId = $(this).val();
        $.ajax({
            url: '/home/get-cities',
            type: 'GET',
            data: {
                province_id: provinceId
            },
            success: function(data) {
                var citySelect = $('#city');
                citySelect.empty().append('<option value="">Pilih Kota</option>');
                $.each(data, function(index, city) {
                    citySelect.append(new Option(city.city_name, city.city_id));
                });
            }
        });
    });

    // Fetch jenis pengiriman berdasarkan ekspedisi yang dipilih
    $('#courier').change(function() {
        var courierCode = $(this).val();
        if (courierCode) {
            $.ajax({
                url: '/home/get-services', // API untuk mengambil layanan berdasarkan ekspedisi
                type: 'GET',
                data: {
                    courier: courierCode,
                    destination: $('#city').val()
                },
                success: function(data) {
                    var serviceSelect = $('#service');
                    serviceSelect.empty().append(
                        '<option value="">Pilih Jenis Pengiriman</option>');
                    var serviceData = data; // Simpan data services di variabel
                    $.each(data, function(index, service) {
                        serviceSelect.append(new Option(service.service, service.service));
                    });

                    // Menambahkan perubahan ongkir setelah memilih service
                    $('#service').change(function() {
                        var selectedService = $(this).val();
                        if (selectedService && serviceData.length > 0) {
                            var selectedServiceData = serviceData.find(function(service) {
                                return service.service === selectedService;
                            });

                            if (selectedServiceData && selectedServiceData.cost) {
                                var ongkir = selectedServiceData.cost[0]
                                    .value; // Ambil ongkir
                                $('input[name="ongkir"]').val(ongkir); // Isi input ongkir
                                updateTotal(ongkir); // Perbarui total dengan ongkir
                            }
                        }
                    });
                }
            });
        } else {
            $('#service').empty().append('<option value="">Pilih Jenis Pengiriman</option>');
        }
    });

    // Fetch ongkos kirim berdasarkan kota tujuan, ekspedisi, dan jenis pengiriman
    $('#city').change(function() {
        var destination = $(this).val();
        var weight = 1000; // Sesuaikan berat produk dalam gram
        var courier = $('#courier').val(); // Ambil ekspedisi yang dipilih
        var service = $('#service').val(); // Ambil jenis pengiriman yang dipilih

        // console.log(destination);

        if (destination && courier && service) {
            $.ajax({
                url: '/home/get-cost',
                type: 'GET',
                data: {
                    destination: destination,
                    weight: weight,
                    courier: courier,
                    service: service
                },
                success: function(data) {
                    console.log(data); // Debugging: cek apakah data diterima dengan benar
                    if (data && data.length > 0 && data[0].costs && data[0].costs.length > 0) {
                        var ongkir = data[0].costs[0].cost[0].value;
                        $('input[name="ongkir"]').val(ongkir); // Update ongkir
                        updateTotal(ongkir); // Perbarui total dengan ongkir
                    } else {
                        $('input[name="ongkir"]').val('Tidak ada biaya pengiriman');
                        updateTotal(0); // Jika tidak ada ongkir, set ke 0
                    }
                },
                error: function(xhr, status, error) {
                    console.log('Error:', error); // Debugging: menampilkan error
                }
            });
        }
    });

    // Fungsi untuk mengupdate total harga
    function updateTotal(ongkir) {
        var totalBelanja = {{ $totalbelanja }}; // Ambil total belanja dari server
        var total = totalBelanja + parseInt(ongkir); // Tambahkan ongkir ke total belanja

        // Update tampilan total di halaman
        $('#total_belanja').val(total); // Update hidden input
        $('p#totalHarga').html('Rp ' + total.toLocaleString() +
            ' <br><span style="color:red; font-weight:400;">NON REFUNDABLE</span>');

        // Update harga di bagian detail
        $('#totalBelanja').html('Rp ' + total.toLocaleString());
    }
</script>
@endsection
