<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserNotificationController;

Route::group(['middleware' => ['auth', 'email.verified', 'installed','mail.config']],function() {

    Route::get('notifications', [UserNotificationController::class, 'index'])->name('notifications.index');

});




