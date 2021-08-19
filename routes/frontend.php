<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;


Route::group(['middleware' => 'installed'], function () {


Route::get('/', [FrontendController::class, 'index'])->name('frontend.index');

/**
 * SLIDER
 */
Route::get('/frontend/setup', [FrontendController::class, 'setup'])->name('frontend.setup');
Route::any('/frontend/store', [FrontendController::class, 'store'])->name('frontend.store');

/**
 * PAYMENT
 */

Route::get('payment/{id}/{plan}', [FrontendController::class, 'payment'])->name('frontend.payment');


/**
 * NEW SUBSCRIPTION
 */

 Route::get('subscribe/for/newsletter',[FrontendController::class, 'newSubscriber'])->name('new.subscription');

});


