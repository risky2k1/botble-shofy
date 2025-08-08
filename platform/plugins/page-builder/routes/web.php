<?php

use Botble\Base\Facades\AdminHelper;
use Botble\PageBuilder\Http\Controllers\PageBuilderController;
use Illuminate\Support\Facades\Route;

AdminHelper::registerRoutes(function () {
    Route::group(['prefix' => 'page-builders', 'as' => 'page-builder.'], function () {
        Route::get('builder', [PageBuilderController::class, 'builder'])->name('builder');
        Route::post('builder/{page_id}/save', [PageBuilderController::class, 'saveBuilder'])->name('save');
    });
});
