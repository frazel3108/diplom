<?php

Route::prefix('characteristic')
    ->namespace('Characteristic')
    ->group(function () {
        Route::get('', ListController::class)
            ->middleware('can:view_characteristic,App\Models\Admin\User')
            ->name('characteristic');

        Route::get('create', CreateController::class)
            ->middleware('can:create_characteristic,App\Models\Admin\User')
            ->name('characteristic.create');
        Route::post('create', StoreController::class)
            ->middleware('can:create_characteristic,App\Models\Admin\User');

        Route::get('{characteristic:id}', ShowController::class)
            ->withTrashed()
            ->middleware('can:view_characteristic,App\Models\Admin\User')
            ->name('characteristic.show');
        Route::put('{characteristic:id}', UpdateController::class)
            ->withTrashed()
            ->middleware('can:update_characteristic,App\Models\Admin\User');
        Route::delete('{characteristic:id}', DeleteController::class)
            ->withTrashed()
            ->middleware('can:delete_characteristic,App\Models\Admin\User');
    });