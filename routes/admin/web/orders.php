<?php

Route::prefix('orders')
    ->namespace('Order')
    ->group(function () {
        Route::get('', ListController::class)
            ->middleware('can:view_order,App\Models\Admin\User')
            ->name('order');

        Route::get('{order:id}', ShowController::class)
            ->withTrashed()
            ->middleware('can:view_order,App\Models\Admin\User')
            ->name('order.show');
    });