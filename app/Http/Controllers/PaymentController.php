<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function callback(Request $request)
    {
        try {
            $invoice_id = $request->invoice['ref'];
            DB::beginTransaction();

            $payment = DB::table('pembelian')
                ->where('notransaksi', $invoice_id)
                ->first();
            if ($payment != null) {
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
                'message' => 'Terjadi kesalahan pada server' . $e->getMessage()
            ], 400);
        }
    }
}
