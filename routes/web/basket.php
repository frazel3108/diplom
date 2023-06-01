<?php

Route::prefix('basket')
    ->middleware(['auth', 'verified'])
    ->group(function() {
        Route::get('/', Basket\ShowController::class)->name('basket');
        Route::post('/', Basket\OrderController::class);
        Route::post('/{product}', Basket\AddController::class)->name('basket.add');
        Route::delete('/remove/{product}', Basket\RemoveController::class)->name('basket.remove');
        Route::delete('/{product}', Basket\DeleteController::class)->name('basket.delete');
    });