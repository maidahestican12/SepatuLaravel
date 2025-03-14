<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait PembelianQueryTrait
{

    protected $db;
    protected $query;

    public function query()
    {
        return $this;
    }

    private function pembelian()
    {
        return DB::table('pembelian');
    }

    private function pengguna()
    {
        return DB::table('pengguna');
    }

    private function pembelianproduk()
    {
        return DB::table('pembelianproduk');
    }
}
