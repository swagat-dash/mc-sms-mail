<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CampaignController;

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


Route::group(['middleware' => ['auth', 'email.verified','installed', 'mail.config']],function() {

    /**
     * CAMPAIGN
     */

    Route::get('/campaign', [CampaignController::class, 'index'])
        ->name('campaign.index');

    Route::get('/campaign/type/{type}', [CampaignController::class, 'type'])
        ->name('campaign.type');

    Route::get('/campaign/create', [CampaignController::class, 'create'])
        ->name('campaign.create');

    Route::get('/campaign/create/{type}', [CampaignController::class, 'createType'])
        ->name('campaign.create.type');

    Route::any('/campaign/create/step1/store', [CampaignController::class, 'step1Store'])
        ->name('campaign.store.step1');

    Route::get('/campaign/create/step2', [CampaignController::class, 'step2'])
        ->name('campaign.store2');

    Route::any('/campaign/create/step2/store', [CampaignController::class, 'step2Store'])
        ->name('campaign.store.store2');

    Route::get('/campaign/create/step3', [CampaignController::class, 'step3'])
        ->name('campaign.store3');

    Route::get('/campaign/emails', [CampaignController::class, 'emails'])
        ->name('campaign.emails');

    Route::any('/campaign/emails/store', [CampaignController::class, 'emailsStore'])
        ->name('campaign.emails.store');

    Route::get('/campaign/emails/destroy/{id}', [CampaignController::class, 'destroy'])
        ->name('campaign.emails.destroy');

    Route::get('/campaign/emails/edit/{id}', [CampaignController::class, 'edit'])
        ->name('campaign.emails.edit');

    Route::any('/campaign/emails/update/{id}', [CampaignController::class, 'update'])
        ->name('campaign.emails.update');

    Route::get('/campaign/send-email/campaign-{campaign_id}/template-{template_id}/', [CampaignController::class, 'campaignSendEmail'])
        ->name('campaign.send.email');


});
