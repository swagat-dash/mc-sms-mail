<?php

use Infureal\Http\Controllers\GuiController;

\Route::get('/', [GuiController::class, 'index'])
    ->name('gui.index')->middleware('can:Admin');

\Route::post('{command}', [GuiController::class, 'run'])
    ->name('gui.run')->middleware('can:Admin');