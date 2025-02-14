<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Home;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index']);

// Route::get('/kategori', [KategoriController::class,'index']);

Route::controller(AdminController::class)->group(function () {
    Route::get('admin', 'index');
    Route::get('admin/kategori', 'kategori');
    Route::get('admin/tambahkategori', 'tambahkategori');
    Route::post('admin/simpankategori', 'simpankategori');
    Route::get('admin/ubahkategori/{id}', 'ubahkategori');
    Route::post('admin/updatekategori/{id}', 'updatekategori');
    Route::get('admin/hapuskategori/{id}', 'hapuskategori');

    Route::get('admin/produk', 'produk');
    Route::get('admin/tambahproduk', 'tambahproduk');
    Route::post('admin/simpanproduk', 'simpanproduk');
    Route::get('admin/ubahproduk/{id}', 'ubahproduk');
    Route::post('admin/updateproduk/{id}', 'updateproduk');
    Route::get('admin/hapusproduk/{id}', 'hapusproduk');

    Route::get('admin/profile', 'profile');
    Route::get('admin/tambahprofile', 'tambahprofile');
    Route::post('admin/simpanprofile', 'simpanprofile');
    Route::get('admin/ubahprofile/{id}', 'ubahprofile');
    Route::post('admin/updateprofile/{id}', 'updateprofile');
    Route::get('admin/hapusprofile/{id}', 'hapusprofile');

    Route::get('admin/artikel', 'artikel');
    Route::get('admin/tambahartikel', 'tambahartikel');
    Route::post('admin/simpanartikel', 'simpanartikel');
    Route::get('admin/ubahartikel/{id}', 'ubahartikel');
    Route::post('admin/updateartikel/{id}', 'updateartikel');
    Route::get('admin/hapusartikel/{id}', 'hapusartikel');

    Route::get('admin/pengguna', 'pengguna');
    Route::get('admin/tambahpengguna', 'tambahpengguna');
    Route::post('admin/simpanpengguna', 'simpanpengguna');
    Route::get('admin/ubahpengguna/{id}', 'ubahpengguna');
    Route::post('admin/updatepengguna/{id}', 'updatepengguna');
    Route::get('admin/hapuspengguna/{id}', 'hapuspengguna');

    Route::get('admin/kurir', 'kurir');
    Route::get('admin/tambahkurir', 'tambahkurir');
    Route::post('admin/simpankurir', 'simpankurir');
    Route::get('admin/ubahkurir/{id}', 'ubahkurir');
    Route::post('admin/updatekurir/{id}', 'updatekurir');
    Route::get('admin/hapuskurir/{id}', 'hapuskurir');

    Route::get('admin/logout', 'logout');
    Route::get('admin/exportpdf', 'exportpdf');

    Route::get('admin/pembelian', 'pembelian');
    Route::get('admin/pembayaran/{id}', 'pembayaran');
    Route::post('admin/simpanpembayaran/{id}', 'simpanpembayaran');
    Route::get('admin/laporan', 'laporan');
    Route::post('admin/laporancetak', 'laporancetak');

    Route::get('admin/pembeliankurir', 'pembeliankurir');
    Route::get('admin/pembayarankurir/{id}', 'pembayarankurir');
    Route::post('admin/simpanpembayarankurir/{id}', 'simpanpembayarankurir');
});

Route::controller(HomeController::class)->group(function () {
    Route::get('home', 'index');
    Route::get('home/produkdaftar', 'produkdaftar');
    Route::get('home/artikel', 'artikel');
    Route::get('home/produkfilter', 'produkfilter');
    Route::get('home/artikelfilter', 'artikelfilter');
    Route::get('home/kategori', 'kategori');
    Route::get('home/kategori/{id}', 'kategoriproduk');
    Route::get('home/kategorifilter', 'kategorifilter');
    Route::get('home/detail/{id}', 'detail');
    Route::get('home/detailartikel/{id}', 'detailartikel');
    Route::get('home/deletenotification/{id}', 'deletenotification');
    Route::get('home/bersihkannotifikasi', 'bersihkannotifikasi');

    Route::get('home/login', 'login');
    Route::post('home/dologin', 'dologin');
    Route::get('home/daftar', 'daftar');
    Route::post('home/dodaftar', 'dodaftar');
    Route::get('home/tentang', 'tentang');

    Route::get('home/akun', 'akun');
    Route::post('home/ubahakun/{id}', 'ubahakun');

    Route::get('home/keranjang', 'keranjang');
    Route::get('home/hapuskeranjang/{id}', 'hapuskeranjang');
    Route::get('home/checkout', 'checkout');
    Route::post('home/docheckout', 'docheckout');
    Route::get('home/riwayat', 'riwayat');
    Route::get('home/logout', 'logout');

    Route::get('home/get-provinces', 'getProvince');
    Route::get('home/get-cities', 'getCity');
    Route::get('home/get-cost', 'getCost');
    Route::get('home/get-couriers', 'getCouriers');
    Route::get('home/get-services', 'getServices');

    Route::post('home/pesan', 'pesan');
    Route::get('home/invoice/{id}', 'invoice');
    Route::get('home/detailtransaksi/{id}', 'detailtransaksi');
    Route::get('home/pembayaran/{id}', 'pembayaran');
    Route::post('home/pembayaransimpan', 'pembayaransimpan');
    Route::post('home/selesai', 'selesai');

    Route::get('home/prosespembayaran/{idtransaksi}', 'prosespembayaran');

});
