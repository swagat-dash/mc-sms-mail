<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StripeController;

Route::group(['middleware' => ['installed','mail.config']],function() {

Route::get('/stripe-payment/interface', [StripeController::class, 'getPaymentWithStripe'])
        ->name('getPaymentWithStripe');

Route::any('/stripe-payment', [StripeController::class, 'handlePost'])
        ->name('stripe.payment');
});
