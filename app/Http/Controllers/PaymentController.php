<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function callback(Request $request)
    {
        //pengaman supaya tidak ada masaslah di bagian database atau apa dan supaya bisa nge rollback
        try {
            $invoice_id = $request->invoice['ref'];
            DB::beginTransaction(); //misalkan terjadi masalah dari database, misalnya database error itu msih bisa ngerollback, kalo tidak ada konflik dibakal ngecommit jadi perubahan fungsingnya itu dilakukan

            $payment = DB::table('pembelian')
                ->where('notransaksi', $invoice_id)
                ->first();
            if ($payment != null) {//transaksi /pembeliannya hilang atau ke hapuss terus sudah dibayar, teruss transaksinya mau update apaa makanya dikass if
                DB::table('pembelian')
                    ->where('notransaksi', $invoice_id)->update([
                        'statusbeli' => 'Sudah Upload Bukti Pembayaran'
                    ]);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan pada server'
            ], 400);
        }
    }
}
