<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function index()
    {
        $produk = DB::table('produk')->Join('kategori', 'produk.idkategori', '=', 'kategori.idkategori')->orderBy('idproduk', 'desc')->limit(6)->get();
        $data = [
            'produk' => $produk,
        ];

        return view('home/index', $data);
    }

    public function deletenotification($id)
    {
        DB::table('notifikasi')->where('idnotifikasi', $id)->delete();
        return back();
    }

    public function bersihkannotifikasi()
    {
        $iduser = session('pengguna')->id;
        DB::table('notifikasi')->where('id', $iduser)->delete();
        return back();
    }

    public function produkdaftar()
    {
        $produk = DB::table('produk')->leftJoin('kategori', 'produk.idkategori', '=', 'kategori.idkategori')->orderBy('idproduk', 'desc')->paginate(6);
        $data = [
            'produk' => $produk,
        ];
        return view('home/produk', $data);
    }

    public function artikel()
    {
        $artikel = DB::table('artikel')->orderBy('idartikel', 'desc')->paginate(6);
        $data = [
            'artikel' => $artikel,
        ];
        return view('home/artikel', $data);
    }

    public function tentang()
    {
        return view('home/tentang');
    }

    public function produkfilter(Request $request)
    {
        $query = DB::table('produk')
            ->leftJoin('kategori', 'produk.idkategori', '=', 'kategori.idkategori')
            ->select('produk.*', 'kategori.namakategori');

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('produk.nama', 'like', '%' . $search . '%')
                ->orWhere('kategori.namakategori', 'like', '%' . $search . '%');
        }

        if ($request->has('sort_by')) {
            $sortBy = $request->input('sort_by');
            if ($sortBy == 'price_asc') {
                $query->orderBy('produk.harga', 'asc');
            } elseif ($sortBy == 'price_desc') {
                $query->orderBy('produk.harga', 'desc');
            } elseif ($sortBy == 'name_asc') {
                $query->orderBy('produk.nama', 'asc');
            } elseif ($sortBy == 'name_desc') {
                $query->orderBy('produk.nama', 'desc');
            } else {
                $query->orderBy('produk.idproduk', 'desc');
            }
        } else {
            $query->orderBy('produk.idproduk', 'desc');
        }

        $produk = $query->paginate(6);

        $data = [
            'produk' => $produk,
        ];
        return view('home/produk', $data);
    }

    public function kategori()
    {
        $kategori = DB::table('kategori')->paginate(8);

        $data = [
            'kategori' => $kategori,
        ];

        return view('home.kategori', $data);
    }

    public function kategoriproduk($id)
    {
        $data['produk'] = DB::table('produk')->leftJoin('kategori', 'produk.idkategori', '=', 'kategori.idkategori')->where('produk.idkategori', $id)->orderBy('idproduk', 'desc')->paginate(6);

        return view('home/kategoriproduk', $data);
    }

    public function kategorifilter(Request $request)
    {
        $query = DB::table('produk')
            ->leftJoin('kategori', 'produk.idkategori', '=', 'kategori.idkategori')
            ->select('produk.*', 'kategori.namakategori');

        // Search functionality
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('produk.nama', 'like', '%' . $search . '%')
                    ->orWhere('kategori.namakategori', 'like', '%' . $search . '%');
            });
        }

        // Category filtering
        if ($request->has('category_id') && $request->input('category_id') != '') {
            $categoryId = $request->input('category_id');
            $query->where('produk.idkategori', $categoryId);
        }

        // Sorting functionality
        if ($request->has('sort_by')) {
            $sortBy = $request->input('sort_by');
            if ($sortBy == 'price_asc') {
                $query->orderBy('produk.harga', 'asc');
            } elseif ($sortBy == 'price_desc') {
                $query->orderBy('produk.harga', 'desc');
            } elseif ($sortBy == 'name_asc') {
                $query->orderBy('produk.nama', 'asc');
            } elseif ($sortBy == 'name_desc') {
                $query->orderBy('produk.nama', 'desc');
            } else {
                $query->orderBy('produk.idproduk', 'desc');
            }
        } else {
            $query->orderBy('produk.idproduk', 'desc');
        }

        $produk = $query->paginate(6);
        $allCategories = DB::table('kategori')->get(); // Fetch all categories

        $data = [
            'produk' => $produk,
            'allCategories' => $allCategories,
        ];

        return view('home.kategori', $data);
    }



    public function detail($id)
    {
        $produk = DB::table('produk')->leftJoin('kategori', 'produk.idkategori', '=', 'kategori.idkategori')->where('idproduk', $id)->first();
        $namaLengkap = $produk->nama;
        $namaArray = explode(' ', $namaLengkap);
        $SKU = array_pop($namaArray);
        $produkLainnya = DB::table('produk')
            ->where('idkategori', $produk->idkategori)
            ->where('idproduk', '!=', $id) // Kecualikan produk awal
            ->take(3)
            ->get();
        $data = [
            'produk' => $produk,
            'SKU' => $SKU,
            'produkLainnya' => $produkLainnya,
        ];
        // session()->forget('keranjang');
        // dd(session('keranjang'));
        return view('home.detail', $data);
    }

    public function detailartikel($id)
    {
        $artikel = DB::table('artikel')->where('idartikel', $id)->first();
        $data = [
            'artikel' => $artikel,
        ];
        return view('home.detailartikel', $data);
    }

    public function daftar()
    {
        return view('home.daftar');
    }

    public function dodaftar(Request $request)
    {
        $nama = $request->input('nama');
        $email = $request->input('email');
        $password = $request->input('password');
        $alamat = $request->input('alamat');
        $telepon = $request->input('telepon');
        $jekel = $request->input('jekel');
        $tgl_lahir = $request->input('tgl_lahir');
        $tempat_lahir = $request->input('tempat_lahir');
        $existingUser = DB::table('pengguna')->where('email', $email)->count();

        if ($existingUser == 1) {
            return redirect()->back()->with('alert', 'Pendaftaran Gagal, email sudah ada');
        } else {
            DB::table('pengguna')->insert([
                'nama' => $nama,
                'email' => $email,
                'password' => $password,
                'alamat' => $alamat,
                'telepon' => $telepon,
                'jekel' => $jekel,
                'tgl_lahir' => $tgl_lahir,
                'tempat_lahir' => $tempat_lahir,
                'fotoprofil' => 'Untitled.png',
                'level' => 'Pelanggan'
            ]);

            return redirect('home/login')->with('alert', 'Pendaftaran Berhasil');
        }
    }

    public function login()
    {
        return view('home.login');
    }

    public function dologin(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $akun = DB::table('pengguna')
            ->where('email', $email)
            ->where('password', $password)
            ->first();

        if ($akun) {
            if ($akun->level == "Pelanggan") {
                session(['pengguna' => $akun]);
                return redirect('home')->with('alert', 'Anda sukses login');
            } elseif ($akun->level == "Admin") {
                session(['admin' => $akun]);
                return redirect('admin')->with('alert', 'Anda sukses login');
            } elseif ($akun->level == "Kurir") {
                session(['admin' => $akun]);
                return redirect('admin')->with('alert', 'Anda sukses login');
            }
        } else {
            return redirect()->back()->with('alert', 'Email atau Password anda salah');
        }
    }

    public function logout()
    {
        session()->flush();
        return redirect('home')->with('alert', 'Anda Telah Logout');
    }

    public function akun()
    {
        if (!session('pengguna')) {

            session()->flash('alert', 'Anda belum login. Silakan login terlebih dahulu.');
            return redirect('home/login');
        }

        $idpengguna = session('pengguna')->id;
        $pengguna = DB::table('pengguna')->where('id', $idpengguna)->first();

        $data = [
            'pengguna' => $pengguna,
        ];
        return view('home.akun', $data);
    }

    public function ubahakun(Request $request, $id)
    {
        $password = $request->input('password');
        if (empty($password)) {
            $password = $request->input('passwordlama');
        }
        DB::table('pengguna')
            ->where('id', $id)
            ->update([
                'password' => $password,
                'nama' => $request->input('nama'),
                'email' => $request->input('email'),
                'telepon' => $request->input('telepon'),
                'alamat' => $request->input('alamat'),
                'jekel' => $request->input('jekel'),
                'tgl_lahir' => $request->input('tgl_lahir'),
                'tempat_lahir' => $request->input('tempat_lahir'),
                'provinsi' => $request->input('provinsi'),
                'kota' => $request->input('kota'),
                'kec' => $request->input('kec'),
                'kode_pos' => $request->input('kode_pos'),
            ]);

        return redirect('home/akun');
    }

    public function pesan(Request $request)
    {
        if (!session('pengguna')) {
            session()->flash('alert', 'Anda belum login. Silakan login terlebih dahulu.');
            return redirect('home/login');
        }

        $idproduk = $request->input('idproduk');
        $jumlah = (int) $request->input('jumlah');
        $ukuran = $request->input('ukuran');
        $namafotocustom = '';
        $warna = $request->input('warna');

        if ($request->hasFile('fotocustom')) {
            $fotocustom = $request->file('fotocustom');
            $fotocustomName = time() . '.' . $fotocustom->getClientOriginalExtension();
            $fotocustom->move(public_path('foto'), $fotocustomName);
            // $data['fotocustom'] = $fotocustomName;
            $namafotocustom = $fotocustomName;
        } else {
            $namafotocustom = '';
        }

        // Ambil informasi produk dari database
        $produk = DB::table('produk')->where('idproduk', $idproduk)->first();

        if (!$produk) {
            session()->flash('alert', 'Produk tidak ditemukan.');
            return back();
        }

        $keranjang = session()->get('keranjang', []);
        $jumlahTotal = $jumlah;

        if (isset($keranjang[$idproduk])) {
            $jumlahTotal += $keranjang[$idproduk]['jumlah'];
        }

        if ($jumlahTotal > $produk->stok) {
            session()->flash('alert', 'Jumlah yang diminta melebihi stok yang tersedia.');
            return back();
        }

        if (isset($keranjang[$idproduk])) {
            $keranjang[$idproduk]['jumlah'] += $jumlah;
        } else {
            $keranjang[$idproduk] = [
                'nama' => $produk->nama,
                'harga' => $produk->harga,
                'foto' => $produk->foto,
                'jumlah' => $jumlah,
                'ukuran' => $ukuran,
                'fotocustom' => $namafotocustom,
                'warna' => $warna,
            ];
        }

        session(['keranjang' => $keranjang]);
        session()->flash('alert', 'Berhasil menambahkan data ke keranjang');
        return redirect('home/keranjang');
    }


    public function keranjang()
    {
        if (!session('pengguna')) {
            session()->flash('alert', 'Anda belum login. Silakan login terlebih dahulu.');
            return redirect('home/login');
        }

        $keranjang = session()->get('keranjang', []);

        // Ambil semua produk dari database berdasarkan idproduk yang ada di keranjang
        $produkIds = array_keys($keranjang);
        $produks = DB::table('produk')->whereIn('idproduk', $produkIds)->get()->keyBy('idproduk');

        // dd($keranjang);
        return view('home.keranjang', [
            'keranjang' => $keranjang,
            'produks' => $produks
        ]);
    }



    public function hapuskeranjang($id)
    {
        $keranjang = session()->get('keranjang');

        if (isset($keranjang[$id])) {
            unset($keranjang[$id]);
            session(['keranjang' => $keranjang]);
        }
        return redirect('home/keranjang');
    }

    public function checkout()
    {
        if (!session('pengguna')) {

            session()->flash('alert', 'Anda belum login. Silakan login terlebih dahulu.');
            return redirect('home/login');
        }
        $keranjang = session()->get('keranjang');
        $data['keranjang'] = $keranjang;


        $caripengguna = session('pengguna')->id;
        $pengguna = DB::table('pengguna')->where('id', $caripengguna)->first();
        $data['pengguna'] = $pengguna;
        return view('home.checkout', $data);
    }

    // Ambil Daftar Provinsi
    public function getProvince()
    {
        $response = Http::withHeaders([
            'key' => '9f24879753df09360af8609396961e06'
        ])->get('https://api.rajaongkir.com/starter/province');

        return response()->json($response['rajaongkir']['results']);
    }

    // Ambil Daftar Kota berdasarkan ID Provinsi
    public function getCity(Request $request)
    {
        $response = Http::withHeaders([
            'key' => '9f24879753df09360af8609396961e06'
        ])->get('https://api.rajaongkir.com/starter/city', [
            'province' => $request->province_id
        ]);

        return response()->json($response['rajaongkir']['results']);
    }

    // Hitung Ongkos Kirim
    public function getCost(Request $request)
    {
        $request->validate([
            'destination' => 'required',
            'weight' => 'required|integer|min:1'
        ]);

        $response = Http::withHeaders([
            'key' => '9f24879753df09360af8609396961e06'
        ])->post('https://api.rajaongkir.com/starter/cost', [
            'origin'        => '114',
            'destination'   => $request->destination,
            'weight'        => $request->weight,
            'courier'       => 'jne' // Bisa diubah ke tiki/pos sesuai kebutuhan
        ]);

        return response()->json($response['rajaongkir']['results']);
    }


    public function getServices(Request $request)
    {
        $courier = $request->get('courier');
        $destination = $request->get('destination');
        $rajaongkirApiKey = '9f24879753df09360af8609396961e06';
        $url = "https://api.rajaongkir.com/starter/cost";

        $response = Http::withHeaders([
            'key' => $rajaongkirApiKey
        ])->post($url, [
            'origin' => 114, // ID kota asal, misalnya Semarang
            'destination' => $destination, // ID kota tujuan
            'weight' => 1000, // Berat barang dalam gram
            'courier' => $courier
        ]);

        $services = $response->json()['rajaongkir']['results'][0]['costs'];

        return response()->json($services);
    }


    public function docheckout(Request $request)
    {
        $notransaksi = '#TP' . date("Ymdhis");
        $id = session('pengguna')->id;
        $tanggalbeli = date("Y-m-d");
        $waktu = date("Y-m-d H:i:s");
        $totalbeli = $request->input('total_belanja');
        $alamatpengirim = $request->input('alamat');
        $provinsi = $request->input('provinsi');
        $kota = $request->input('kota');
        $kec = $request->input('kec');
        $ongkir = $request->input('ongkir');
        $nama = $request->input('nama');
        $telepon = $request->input('telepon');
        $email = $request->input('email');

        if ($request->metodepembayaran == 'Transfer') {
            DB::table('pembelian')->insert([
                'notransaksi' => $notransaksi,
                'id' => $id,
                'tanggalbeli' => $tanggalbeli,
                'nama' => $nama,
                'email' => $email,
                'telepon' => $telepon,
                'totalbeli' => $totalbeli,
                'alamat' => $alamatpengirim,
                'statusbeli' => 'Belum Bayar',
                'provinsi' => '',
                'kota' => '',
                'ongkir' => $ongkir,
                'waktu' => $waktu,
                'metodepembayaran' => $request->metodepembayaran
            ]);
        } elseif ($request->metodepembayaran == 'Cod') {
            DB::table('pembelian')->insert([
                'notransaksi' => $notransaksi,
                'id' => $id,
                'tanggalbeli' => $tanggalbeli,
                'nama' => $nama,
                'email' => $email,
                'telepon' => $telepon,
                'totalbeli' => $totalbeli,
                'alamat' => $alamatpengirim,
                'statusbeli' => 'Menunggu Konfirmasi',
                'ongkir' => $ongkir,
                'waktu' => $waktu,
                'metodepembayaran' => $request->metodepembayaran
            ]);
        }

        $idpembelian = DB::getPdo()->lastInsertId();

        $keranjang = session()->get('keranjang');

        foreach ($keranjang as $idproduk => $item) {
            $produk = DB::table('produk')->where('idproduk', $idproduk)->first();

            DB::table('pembelianproduk')->insert([
                'idpembelian' => $idpembelian,
                'idproduk' => $produk->idproduk,
                'nama' => $produk->nama,
                'harga' => $produk->harga,
                'subharga' => $produk->harga * $item['jumlah'],
                'jumlah' => $item['jumlah'],
                'fotocustom' => $item['fotocustom'],
                'warna' => $item['warna'],
            ]);
        }

        session()->forget('keranjang');
        session()->flash('alert', 'Berhasil Checkout');
        return redirect('home/riwayat');
    }


    public function riwayat()
    {
        if (!session('pengguna')) {

            session()->flash('alert', 'Anda belum login. Silakan login terlebih dahulu.');
            return redirect('home/login');
        }
        $idpengguna = session('pengguna')->id;
        $databeli = DB::table('pembelian')
            ->leftJoin('pembayaran', 'pembelian.idpembelian', '=', 'pembayaran.idpembelian')
            ->select('*', 'pembelian.idpembelian as idpembelianreal')
            ->where('pembelian.id', $idpengguna)
            ->orderBy('pembelian.tanggalbeli', 'desc')
            ->orderBy('pembelian.idpembelian', 'desc')
            ->paginate(10);

        $dataproduk = [];
        foreach ($databeli as $row) {
            $idpembelian = $row->idpembelianreal;
            $produk = DB::table('pembelianproduk')
                ->join('produk', 'pembelianproduk.idproduk', '=', 'produk.idproduk')
                ->where('idpembelian', $idpembelian)
                ->get();
            $dataproduk[$idpembelian] = $produk;
        }

        $data = [
            'databeli' => $databeli,
            'dataproduk' => $dataproduk,
        ];

        return view('home.riwayat', $data);
    }

    public function invoice($id)
    {
        if (!session('pengguna')) {

            session()->flash('alert', 'Anda belum login. Silakan login terlebih dahulu.');
            return redirect('home/login');
        }
        $datapembelian = DB::table('pembelian')->where('pembelian.idpembelian', $id)->first();
        $dataproduk = DB::table('pembelianproduk')
            ->join('produk', 'pembelianproduk.idproduk', '=', 'produk.idproduk')
            ->where('idpembelian', $id)
            ->get();

        $data = [
            'datapembelian' => $datapembelian,
            'dataproduk' => $dataproduk,
        ];

        return view('home.invoice', $data);
    }

    public function detailtransaksi($id)
    {
        if (!session('pengguna')) {

            session()->flash('alert', 'Anda belum login. Silakan login terlebih dahulu.');
            return redirect('home/login');
        }
        $datapembelian = DB::table('pembelian')->join('pengguna', 'pengguna.id', '=', 'pembelian.id')
            ->where('pembelian.idpembelian', $id)->first();
        $dataproduk = DB::table('pembelianproduk')
            ->join('produk', 'pembelianproduk.idproduk', '=', 'produk.idproduk')
            ->where('idpembelian', $id)
            ->get();

        $data = [
            'datapembelian' => $datapembelian,
            'dataproduk' => $dataproduk,
        ];

        return view('home.detailtransaksi', $data);
    }

    public function pembayaran($id)
    {
        if (!session('pengguna')) {

            session()->flash('alert', 'Anda belum login. Silakan login terlebih dahulu.');
            return redirect('home/login');
        }
        $datapembelian = DB::table('pembelian')->join('pengguna', 'pengguna.id', '=', 'pembelian.id')
            ->where('pembelian.idpembelian', $id)->first();
        $dataproduk = DB::table('pembelianproduk')
            ->join('produk', 'pembelianproduk.idproduk', '=', 'produk.idproduk')
            ->where('idpembelian', $id)
            ->get();

        $data = [
            'datapembelian' => $datapembelian,
            'dataproduk' => $dataproduk,
        ];

        return view('home.pembayaran', $data);
    }

    public function pembayaransimpan(Request $request)
    {
        $namabukti = $request->file('bukti')->getClientOriginalName();
        $namafix = date("YmdHis") . $namabukti;
        $request->file('bukti')->move('foto', $namafix);

        $idpembelian = $request->input('idpembelian');
        $nama = $request->input('nama');
        $tanggaltransfer = $request->input('tanggaltransfer');
        $tanggal = date("Y-m-d");

        DB::table('pembayaran')->insert([
            'idpembelian' => $idpembelian,
            'nama' => $nama,
            'tanggaltransfer' => $tanggaltransfer,
            'tanggal' => $tanggal,
            'bukti' => $namafix,
        ]);

        DB::table('pembelian')->where('idpembelian', $idpembelian)->update([
            'statusbeli' => 'Sudah Upload Bukti Pembayaran',
        ]);

        return redirect('home/riwayat')->with('alert', 'Terima kasih');
    }

    public function selesai(Request $request)
    {
        $idpembelian = $request->input('idpembelian');
        DB::table('pembelian')->where('idpembelian', $idpembelian)->update([
            'statusbeli' => 'Selesai'
        ]);
        return redirect('home/riwayat');
    }

    public function prosesPembayaran($idtransaksi)
    {
        // Ambil data transaksi berdasarkan idtransaksi
        $transaksi = DB::table('pembelian')->where('idpembelian', $idtransaksi)->first();

        if (!$transaksi) {
            session()->flash('alert', 'Transaksi tidak ditemukan.');
            return redirect()->back();
        }

        // Data pengguna (ambil dari tabel pengguna)
        $pengguna = DB::table('pengguna')->where('id', $transaksi->id)->first();

        // Ambil produk yang dibeli berdasarkan idpembelian
        $produkDibeli = DB::table('pembelianproduk')
            ->join('produk', 'pembelianproduk.idproduk', '=', 'produk.idproduk')
            ->where('idpembelian', $idtransaksi)
            ->select('pembelianproduk.nama', 'pembelianproduk.jumlah', 'pembelianproduk.harga')
            ->get();

        // Siapkan array untuk daftar produk di payload
        $products = [];
        foreach ($produkDibeli as $produk) {
            $products[] = [
                'name' => $produk->nama,
                'qty' => $produk->jumlah,
                'price' => number_format($produk->harga, 2, '.', ''),
            ];
        }


        $products[] = [
            'name' => 'Ongkos Kirim',
            'qty' => 1,
            'price' => number_format($transaksi->ongkir, 2, '.', ''), // Ambil ongkir dari tabel pembelian
        ];

        // Buat payload untuk API Winpay
        $key = 'J4HHS21F1CY';
        $secretKey = '767bb05eaf9d4663c8cbdcf9086291c96486eb2a';
        $timestamp = date('Y-m-d\TH:i:s+7');
        $signature = hash_hmac('sha256', $timestamp, $secretKey);

        $payload = [
            'customer' => [
                'name' => $pengguna->nama,
                'email' => $pengguna->email,
                'phone' => $pengguna->telepon,
            ],
            'invoice' => [
                'ref' => $transaksi->notransaksi,
                'products' => $products,
            ],
            'interval' => 120,
            'back_url' => url('home/riwayat'),
        ];



        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://checkout.bmstaging.id/api/create");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "X-Winpay-Timestamp: $timestamp",
            "X-Winpay-Key: $key",
            "X-Winpay-Signature: $signature",
        ]);

        $response = curl_exec($ch);
        // $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        // curl_close($ch);
        // print_r($response);
        if ($response) {
            // Decode JSON ke array asosiatif
            $result = json_decode($response, true);

            // Pastikan key 'responseData' dan 'redirect_url' ada dalam respons
            if (isset($result['responseData']['redirect_url'])) {
                return redirect($result['responseData']['redirect_url']);
            } else {
                session()->flash('alert', 'Respons dari API tidak valid: redirect_url tidak ditemukan.');
                return redirect()->back();
            }
        } else {
            session()->flash('alert', 'Gagal menghubungi API pembayaran. Silakan coba lagi.');
            return redirect()->back();
        }
    }


    private function kirimKeWinpay($payload)
    {
        $key = 'J4HHS21F1CY';
        $secretKey = '767bb05eaf9d4663c8cbdcf9086291c96486eb2a';
        $timestamp = date('Y-m-d\TH:i:s+7');
        $signature = hash_hmac('sha256', $timestamp, $secretKey);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://checkout.bmstaging.id/api/create");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "X-Winpay-Timestamp: " . $timestamp,
            "X-Winpay-Key: " . $key,
            "X-Winpay-Signature: " . $signature
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response);
    }
}
