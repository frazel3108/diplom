<?php

Route::prefix('{category:url}')
    ->group(function() {
        Route::get('/', Category\ItemController::class)
            ->name('category');

        Route::prefix('product')
            ->group(function() {
                Route::get('/{product:url}', Product\ItemController::class)
                    ->name('product')
                    ->scopeBindings();

                Route::middleware('auth')
                    ->group(function() {
                        Route::post('/{product:url}', Product\AddController::class);
                        Route::delete('/{product:url}', Product\RemoveController::class);
                    });
            });
    });