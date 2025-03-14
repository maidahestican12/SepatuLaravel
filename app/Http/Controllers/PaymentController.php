<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\SnapPaymentService;
use App\Traits\PembelianQueryTrait;
use Exception;
use Illuminate\Console\View\Components\Alert;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

class PaymentController extends Controller
{
    use PembelianQueryTrait;
    protected $paymentService;

    public function __construct()
    {
        $this->paymentService = new SnapPaymentService();
    }

    public function callback(Request $request)
    {
        try {
            $invoice_id = $request->invoice['ref'];
            DB::beginTransaction();

            $payment = $this->query()
                ->pembelian()
                ->where('notransaksi', $invoice_id)
                ->first();
            if ($payment != null) {
                $this->query()
                    ->pembelian()
                    ->where('notransaksi', $invoice_id)
                    ->update([
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

    public function virtuaAccountCallback(Request $request)
    {
        try {
            DB::beginTransaction();

            $trx_id = explode('-', $request->trxId)[2];
            $is_payment = $this->query()
                ->pembelian()
                ->where('idpembelian', $trx_id)
                ->exists();
            if ($is_payment) {
                $this->query()
                    ->pembelian()
                    ->where('idpembelian', $trx_id)
                    ->update([
                        'statusbeli' => 'Sudah Upload Bukti Pembayaran'
                    ]);
            }
            DB::commit();

            return response()->json([
                'responseCode' => '2002500',
                'responseMessage' => 'Successful'
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan pada server'
            ], 400);
        }
    }

    public function qrisCallback(Request $request)
    {
        try {
            DB::beginTransaction();

            $trx_id = explode('-', $request->originalPartnerReferenceNo)[2];

            $is_payment = $this->query()
                ->pembelian()
                ->where('idpembelian', $trx_id)
                ->first();
            if ($is_payment) {
                $status = $this->query()
                    ->pembelian()
                    ->where('idpembelian', $trx_id)
                    ->update([
                        'statusbeli' => 'Sudah Upload Bukti Pembayaran'
                    ]);
            }
            DB::commit();
            return response()->json([
                'responseCode' => '2002500',
                'responseMessage' => 'Successful'
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan pada server'
            ], 400);
        }
    }

    public function selectPayment($id)
    {
        return view('home.payments.select_payment', ['id' => $id]);
    }

    public function navigatePayment($type, $attribute)
    {
        try {
            $total_price = $this->calculateTotalPrice($attribute);
            $transaction = $this->query()->pembelian()->where('idpembelian', $attribute)->first();
            if ($type == 'alfamart') {
                $response = $this->createVirtualAccountPayment($total_price, 'ALFAMART', $transaction->idpembelian);
                return view('home.payments.retail_payment', ['data' => $response->json('virtualAccountData')]);
            }
            if ($type == 'indomaret') {
                $response = $this->createVirtualAccountPayment($total_price, 'INDOMARET', $transaction->idpembelian);
                return view('home.payments.retail_payment', ['data' => $response->json('virtualAccountData')]);
            }
            if ($type == 'qris') {
                $response = $this->createQrisPayment($total_price, $transaction->idpembelian);
                return view('home.payments.qris_payment', ['data' => $response->json(), 'amount' => $total_price]);
            }
            if ($type == 'bni') {
                $response = $this->createVirtualAccountPayment($total_price, 'BNI', $transaction->idpembelian);
            }
            if ($type == 'bsi') {
                $response = $this->createVirtualAccountPayment($total_price, 'BSI', $transaction->idpembelian);
            }
            if ($type == 'bri') {
                $response = $this->createVirtualAccountPayment($total_price, 'BRI', $transaction->idpembelian);
            }
            if ($type == 'mandiri') {
                $response = $this->createVirtualAccountPayment($total_price, 'MANDIRI', $transaction->idpembelian);
            }
            if ($response->status() != 200) {
                return redirect()->back()->with('failure', 'Terjadi kesalahan pada server');
            }
            return view('home.payments.virtual_account_payment', ['data' => $response->json('virtualAccountData')]);
        } catch (Exception $e) {
            return redirect()->back()->with('failure', 'Transaksi tidak ditemukan');
        }
    }

    private function createQrisPayment(float $amount, $transaction_id)
    {
        $payload = [
            'partnerReferenceNo' => 'INV-' . time() . '-' . $transaction_id,
            'amount' => [
                'value' => $amount,
                'currency' => 'IDR'
            ],
            'validityPeriod' => now()->addHours(3)->format('Y-m-d\TH:i:sP'),
            'additionalInfo' => [
                'isStatic' => false,
            ],
        ];
        $response = $this->paymentService->postPayment(payload: $payload, endpoint: '/v1.0/qr/qr-mpm-generate');
        return $response;
    }

    private function createVirtualAccountPayment(float $amount, string $channel, $transaction_id)
    {
        $payload = [
            'virtualAccountName' => 'Streetwear',
            'trxId' => 'INV-' . time() . '-' . $transaction_id,
            'totalAmount' => [
                'value' => $amount,
                'currency' => 'IDR'
            ],
            'virtualAccountTrxType' => 'c',
            'expiredDate' => now()->addHours(3)->format('Y-m-d\TH:i:sP'),
            'additionalInfo' => [
                'channel' => strtoupper($channel),
            ],
        ];
        return $this->paymentService->postPayment(payload: $payload, endpoint: '/v1.0/transfer-va/create-va');
    }

    private function calculateTotalPrice($id): float|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $transaksi = $this->query()->pembelian()->where('idpembelian', $id)->first();
        if ($transaksi == null) {
            return redirect()->back()->with('failure', 'Transaksi tidak ditemukan');
        }
        return (float) $transaksi->totalbeli;
    }

    public function checkPayment(Request $request)
    {
        $request->validate([
            'trxId' => 'required|string'
        ]);

        $trx_id = explode('-', $request->trxId)[2];
        $transaction = $this->query()->pembelian()
            ->where('idpembelian', $trx_id)
            ->first();
        if ($transaction == null) {
            return redirect('/home/riwayat')->with('failure', 'Transaksi tidak ditemukan');
        };
        if ($transaction->statusbeli == 'Sudah Upload Bukti Pembayaran') {
            return redirect('/home/riwayat')->with('success', 'Pembayaran berhasil diverifikasi');
        }
        return redirect()->back()->with('alert', 'Pembayaran belum diverifikasi');
    }

    public function downloadQris(Request $request)
    {
        $request->validate([
            'imgUrl' => 'required|string'
        ]);
        $filename = 'qris-' . time() . '.png';
        $tempfile = tempnam(sys_get_temp_dir(), $filename);
        copy($request->imgUrl, $tempfile);
        return response()->download($tempfile, $filename);
    }

    public function checkQris(Request $request)
    {
        $request->validate([
            'contract_id' => 'required|string',
            'original_partner_reference' => 'required|string'
        ]);

        $response = $this->paymentService->postPayment(
            payload: [
                'originalPartnerReference' => $request->original_partner_reference,
                'serviceCode' => '47',
                'additionalInfo' => [
                    'contractId' => $request->contract_id
                ]
            ],
            endpoint: '/v1.0/qr/qr-mpm-query'
        );
        return response()->json($response->json(), 200);
    }
}
