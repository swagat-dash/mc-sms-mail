<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubscriptionPlanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['middleware' => ['auth', 'email.verified', 'installed','mail.config']],function() {

    Route::any('/subscription/store', [SubscriptionPlanController::class, 'store'])
    ->name('subscription.store')
    ->middleware('can:Admin')
    ->middleware('mail.config');
    
});

Route::get('/subscription', [SubscriptionPlanController::class, 'index'])
    ->name('subscription.index')
    ->middleware('installed')
    ->middleware('mail.config');

Route::get('/subscription/edit/{id}', [SubscriptionPlanController::class, 'edit'])
->name('subscription.edit')
->middleware('can:Admin')
->middleware('mail.config');

Route::any('/subscription/update/{id}', [SubscriptionPlanController::class, 'update'])
->name('subscription.update')
->middleware('can:Admin')
->middleware('installed')
->middleware('mail.config');

Route::get('/subscription/delete/{id}', [SubscriptionPlanController::class, 'destroy'])
->name('subscription.delete')
->middleware('can:Admin')
->middleware('installed')
->middleware('mail.config');


