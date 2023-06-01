<?php

Route::prefix('offers')
    ->namespace('Offer')
    ->group(function () {
        Route::get('', ListController::class)
            ->middleware('can:view_offer,App\Models\Admin\User')
            ->name('offer');

        Route::get('create', CreateController::class)
            ->middleware('can:create_offer,App\Models\Admin\User')
            ->name('offer.create');
        Route::post('create', StoreController::class)
            ->middleware('can:create_offer,App\Models\Admin\User');

        Route::get('{offer:id}', ShowController::class)
            ->withTrashed()
            ->middleware('can:view_offer,App\Models\Admin\User')
            ->name('offer.show');
        Route::put('{offer:id}', UpdateController::class)
            ->withTrashed()
            ->middleware('can:update_offer,App\Models\Admin\User');
        Route::delete('{offer:id}', DeleteController::class)
            ->withTrashed()
            ->middleware('can:delete_offer,App\Models\Admin\User');
    });
