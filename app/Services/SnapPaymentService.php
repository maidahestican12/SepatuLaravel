<?php

namespace App\Services;

use Spatie\Crypto\Rsa\KeyPair;
use Spatie\Crypto\Rsa\PublicKey;
use Spatie\Crypto\Rsa\PrivateKey;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Laravel\SerializableClosure\Serializers\Signed;

class SnapPaymentService
{
    public $winpay_snap_url = 'https://sandbox-api.bmstaging.id/snap';
    public $timestamp;
    protected $key;
    protected $secretKey;

    public function __construct()
    {
        $this->timestamp = now()->format('Y-m-d\TH:i:sP');
        $this->key = config('winpay.key');
        $this->secretKey = config('winpay.secret_key');
    }

    public function postPayment(array $payload, string $endpoint)
    {
        $signature = $this->generateSignature('POST', $payload, $endpoint);
        return Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'X-TIMESTAMP' => $this->timestamp,
            'X-SIGNATURE' => $signature,
            'X-PARTNER-ID' => 'dba70ddb-56e9-4175-b412-f39625156f66',
            'X-EXTERNAL-ID' => uniqid(),
            'CHANNEL-ID' => 'WEB',
        ])->post($this->winpay_snap_url . $endpoint, $payload);
    }

    public function generateSignature(
        string $method = 'POST',
        string|array $payload,
        string $endpointUrl,

    ): string {
        if (!File::exists(storage_path('private_key.pem'))) {
            $this->generateKeyPair();
        }
        $privateKey = PrivateKey::fromFile(storage_path('private_key.pem'));
        $timestamp = $this->timestamp;

        if (is_array($payload)) {
            $payload = json_encode($payload, JSON_UNESCAPED_SLASHES);
        }
        $hashed_payload = hash('sha256', $payload, true);
        $string_to_sign = [
            $method,
            $endpointUrl,
            strtolower(bin2hex($hashed_payload)),
            $timestamp,
        ];
        $string_to_sign = implode(':', $string_to_sign);
        return $privateKey->sign($string_to_sign, OPENSSL_ALGO_SHA256);
    }

    protected function generateKeyPair(): void
    {
        $keyPair = new KeyPair();
        $keyPair->generate(
            privateKeyPath: storage_path('private_key.pem'),
            publicKeyPath: storage_path('public_key.pem'),
        );
    }

    public function verifySignature(string $signature, string $raw_data)
    {
        $signature = base64_decode($signature);
        $publicKey = PublicKey::fromFile(storage_path('public_key.pem'));
        return $publicKey->verify($raw_data, $signature);
    }
}
