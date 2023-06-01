<?php

Route::name('lk.')
    ->prefix('lk')
    ->group(function() {
        Auth::routes(['verify' => true]);
        Route::middleware('auth')
            ->namespace('Lk')
            ->group(function() {
                Route::get('/', HomeController::class)->name('home');
                Route::get('/orders', Order\ShowController::class)->name('order_history');

                require __DIR__ . '/basket.php';

                Route::get('/setting', Setting\ShowController::class)->name('setting');
                Route::delete('/setting/{user:id}', Setting\DeleteController::class)->name('setting.delete');
                Route::put('/setting/{user:id}', Setting\UpdateController::class)->name('setting.update');
            });
    });