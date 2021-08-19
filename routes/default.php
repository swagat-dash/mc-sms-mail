<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SmtpController;
use App\Http\Controllers\SendingServerController;
use App\Http\Controllers\OrganizationSetupController;
use Auth;
use Config;
use App\Models\User;

/**
 * EMAIL VERIFICATION 
 */

Route::group(['middleware' => ['auth','installed','mail.config']],function() {
    Route::get('email/verification/user', [AuthController::class, 'emailVerificationWithCode'])->name('email.verification.with.code'); // email verification
    Route::get('email/verification/code', [AuthController::class, 'emailVerificationCode'])->name('email.verification.code'); // email verification code send to email
    Route::get('email/verification/code/match', [AuthController::class, 'emailVerificationMatch'])->name('email.verification.code.match'); // email verification code match
});

Route::any('send/new/password', [AuthController::class, 'generateNewPassword'])->name('send.new.password')->middleware('installed'); // generate new password

/**
 * REGISTRATION
 */

Route::any('/user/register', [RegisterController::class, 'user_register'])->name('user_register')->middleware('installed');

Auth::routes();

/**
 * AUTH
 */

Route::group(['middleware' => ['auth', 'email.verified', 'installed','mail.config']],function() {

    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->middleware('installed')
        ->name('dashboard');

    Route::get('logout', [AuthController::class, 'logout'])->middleware('installed')
        ->name('logout');

    /**
     * Language
     */

    Route::get('language',[LanguageController::class, 'langIndex'])->middleware('installed')
        ->middleware('can:Admin')
        ->name('language.index');
    Route::get('language/new',[LanguageController::class, 'langNew'])->middleware('installed')
        ->middleware('can:Admin')
        ->name('language.new');
    Route::any('language/store', [LanguageController::class, 'langStore'])->middleware('installed')
        ->middleware('can:Admin')
        ->name('language.store');
    Route::get('language/destroy/{id}', [LanguageController::class, 'langDestroy'])->middleware('installed')
        ->middleware('can:Admin')
        ->name('language.destroy');
    Route::get('language/translate/{id}', [LanguageController::class, 'translate_create'])->middleware('installed')
        ->middleware('can:Admin')
        ->name('language.translate');
    Route::any('language/translate/store', [LanguageController::class, 'translate_store'])->middleware('installed')
        ->middleware('can:Admin')
        ->name('language.translate.store');
    Route::any('language/change', [LanguageController::class, 'languagesChange'])->middleware('installed')
        ->name('language.change');
    Route::get('language/default/{id}', [LanguageController::class, 'defaultLanguage'])->middleware('installed')
        ->name('language.default');

    /**
    * PROFILE
    */

    Route::get('/profile', [ProfileController::class, 'index'])->middleware('installed')
        ->name('profile.index');
    Route::get('/change-password', [ProfileController::class, 'change_password'])->middleware('installed')
        ->name('profile.change.password')->middleware('password.confirm');
    Route::any('/password-changed', [ProfileController::class, 'password_changed'])->middleware('installed')
        ->name('profile.password.changed');
    Route::any('/user/update', [UserController::class, 'update'])->middleware('installed')
        ->name('user.update');
    Route::any('/user/personal/update', [UserController::class, 'personal_update'])->middleware('installed')
        ->name('user.personal.update');

    /**
    * Organization
    */

    Route::get('/organization', [OrganizationSetupController::class, 'index'])
    ->middleware('can:Admin')->middleware('installed')
        ->name('org.index');
    Route::any('/organization/setup', [OrganizationSetupController::class, 'setup'])
    ->middleware('can:Admin')->middleware('installed')
        ->name('org.setup');

    /**
    * seo
    */

    Route::get('/seo', [SeoController::class, 'index'])
    ->middleware('can:Admin')->middleware('installed')
        ->name('seo.index');
    Route::any('/seo/setup', [SeoController::class, 'setup'])
    ->middleware('can:Admin')->middleware('installed')
        ->name('seo.setup');

    /**
    * SMTP
    */

    Route::get('/smtp', [SmtpController::class, 'index'])
    ->middleware('installed')
        ->name('smtp.index');
    Route::get('/smtp/configure/{mail}', [SmtpController::class, 'configure'])
    ->middleware('installed')
        ->name('smtp.configure');
    Route::any('/smtp/configure/{mail}/store', [SmtpController::class, 'store'])
    ->middleware('installed')
        ->name('smtp.configure.store');
    Route::get('/smtp/configure/{mail}/set-default', [SmtpController::class, 'set_default'])
    ->middleware('installed')
        ->name('smtp.configure.default');
    Route::get('/smtp/test-connection', [SmtpController::class, 'test'])
    ->middleware('installed')
        ->name('smtp.connection.test');

    /**
     * System SMTP
     */

    Route::get('/system/smtp/setup/{mail}', [SmtpController::class, 'setAsSystemSmtp'])
    ->middleware('can:Admin')->middleware('installed')
        ->name('system.smtp.setup');

    /**
    * Payment Setup
    */

    Route::get('/payment-setup/paypal', [PaymentSetupController::class, 'paypal'])
    ->middleware('can:Admin')->middleware('installed')
        ->name('payment.setup.paypal');
    Route::get('/payment-setup/paypal/create', [PaymentSetupController::class, 'paypalCreate'])
    ->middleware('can:Admin')->middleware('installed')
        ->name('payment.setup.paypal.create');

    Route::get('/payment-setup/stripe', [PaymentSetupController::class, 'stripe'])
    ->middleware('can:Admin')->middleware('installed')
        ->name('payment.setup.stripe');

    Route::get('/payment-setup/stripe/create', [PaymentSetupController::class, 'stripeCreate'])
    ->middleware('can:Admin')->middleware('installed')
        ->name('payment.setup.stripe.create');

    /**
     * PURCHASED PLANS
     */

     Route::get('/purchased/plans', [PurchasedPlanController::class, 'index'])->name('purchased.plan')->middleware('installed');

     Route::get('/download/invoice/{invoice}', [PurchasedPlanController::class, 'downloadInvoice'])->name('download.invoice')->middleware('installed');

     /**
      * SERVER STATUS
      */

      Route::get('server/status',[ServerStatusController::class, 'index'])->name('server.status')->middleware('installed')->middleware('can:Admin');


    //END

});
