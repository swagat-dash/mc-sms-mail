<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use App\Http\Controllers\API\TemplateBuilderApiController;
use Illuminate\Support\Str;
use Auth;


Route::group(['middleware' => ['auth', 'email.verified','installed', 'mail.config']],function() {

    /**
     * TEMPLETE BUILDER
     */

    Route::get('/template-builder/originate', [TemplateBuilderController::class, 'originate'])
        ->name('template.builder.originate');

    Route::any('/template-builder/originate/create', [TemplateBuilderController::class, 'originateCreate'])
        ->name('template.builder.originate.create');

    Route::get('/template-builder', [TemplateBuilderController::class, 'create'])
        ->name('template.builder.create');

    /**
     * PREVIEW
     */

    Route::get('/email/templates', [TemplateBuilderApiController::class, 'index'])
            ->name('templates.index');

    Route::get('/template/{id}', [TemplateBuilderApiController::class, 'previewDetail'])
            ->name('template.preview');

    Route::get('/template/duplicate/{id}', [TemplateBuilderApiController::class, 'templateDuplicate'])
            ->name('template.duplicate');

    Route::get('/email/template/delete/{id}/{slug}', [TemplateBuilderApiController::class, 'delete'])
            ->name('template.builder.delete');

    Route::any('/email/template/create', [TemplateBuilderApiController::class, 'store'])
            ->name('api.template.page.create');

    Route::any('/email/template/update/{id}', [TemplateBuilderController::class, 'update'])
            ->name('template.page.update');

    Route::any('/email/template/originate/update/{id}', [TemplateBuilderController::class, 'originateUpdate'])
            ->name('template.page.originate.update');

    /**
     * EDIT
     */
     
    Route::get('/template-builder/edit/{id}/{slug}', [TemplateBuilderController::class, 'edit'])
        ->name('template.builder.edit');
        
        Route::get('/template-builder/edit/thumbnail/{id}/{slug}', [TemplateBuilderController::class, 'editThumbnail'])
        ->name('template.builder.edit.thumbnail');
        
        /**
         * IMPORT
         */
        
       Route::get('/template/import', [TemplateBuilderController::class, 'templateImport'])
           ->name('template.import');

});