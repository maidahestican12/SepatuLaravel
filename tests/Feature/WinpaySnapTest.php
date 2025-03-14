<?php

namespace Tests\Feature;

use App\Services\SnapPaymentService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WinpaySnapTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $winpay_service = new SnapPaymentService();
        $payload = [
            'virtualAccountName' => 'Ahmad Pradipta',
            'trxId' => 'INV-' . time(),
            'totalAmount' => [
                'value' => '200000.00',
                'currency' => 'IDR'
            ],
            'virtualAccountTrxType' => 'c',
            'expiredDate' => now()->addHours(2)->format('Y-m-d\TH:i:s+7'),
            'additionalInfo' => [
                'channel' => "BRI",
            ],
        ];
        $response = $winpay_service->initPayment()
            ->post($winpay_service->winpay_snap_url . '/transfer-va/create-va', $payload)
            ->json();


        $this->assertArrayHasKey('data', $response);
    }
}
