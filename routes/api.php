<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use App\Services\SnapPaymentService;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/payment/callback', [PaymentController::class, 'callback']);

Route::post('/payment/verify', function (Request $request) {
    $winpay_service = new SnapPaymentService();
    $verified = $winpay_service->verifySignature($request->signature, $request->raw_data);
    return response()->json(['verified' => $verified]);
});

Route::post('/snap/callback/v1.0/transfer-va/payment', [PaymentController::class, 'virtuaAccountCallback'])
    ->middleware('snap_signature');
Route::post('/snap/callback/v1.0/qr/qr-mpm-notify', [PaymentController::class, 'qrisCallback'])
    ->middleware('snap_signature');
