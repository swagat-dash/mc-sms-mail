<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Auth;
use Artisan;
use App\Http\Controllers\MailLogController;


Route::group(['middleware' => ['auth', 'email.verified', 'installed','mail.config']],function() {

    Route::get('/mail/activities', [MailLogController::class, 'index'])->name('mail.activity.index');
    Route::get('/mail/logs', [MailLogController::class, 'logs'])->name('mail.log.index');

});
