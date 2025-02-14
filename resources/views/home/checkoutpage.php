<?php
// $key = "L50NERUTKOYE";
// $secretKey = "npqq87hl967igj57z1z91kxnl6qb6cba";

$key = 'J4HHS21F1CY';
$secretKey = '767bb05eaf9d4663c8cbdcf9086291c96486eb2a';

$timestamp = date('Y-m-dTH:i:s+7');
$signature = hash_hmac('sha256', $timestamp, $secretKey);

$payload = '{
    "customer": {
        "name": "Ghalib Nugroho",
        "email": "chus@pandi.com",
        "phone": "08202305256679"
    },
    "invoice": {
        "ref": "aax",
        "products": [
            {
                "name": "Jasa pengiriman: JNE - OKE",
                "qty": 1,
                "price": "600000.00"
            },
            {
                "name": "Discont",
                "qty": 1,
                "price": "2000.00"
            }
        ]
    },
    "interval": 120,
    "back_url": "javascript:window.close();"
  }';

  // die(json_decode($payload));

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://checkout.bmstaging.id/api/create");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);

curl_setopt($ch, CURLOPT_POST, TRUE);

curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

curl_setopt($ch, CURLOPT_HTTPHEADER, array(
"Content-Type: application/json",
"X-Winpay-Timestamp: ".$timestamp,
"X-Winpay-Key: ".$key,
"X-Winpay-Signature: ".$signature
));

$response = curl_exec($ch);
curl_close($ch);

print_r($response);