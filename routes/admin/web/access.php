<?php

Route::prefix('access')
    ->namespace('Access')
    ->group(function () {
        Route::get('', ListController::class)
            ->middleware('can:view_admin__roles,App\Models\Admin\User')
            ->name('access');

        Route::get('{role:id}', ShowController::class)
            ->middleware('can:view_admin__roles,App\Models\Admin\User')
            ->name('access.show');
        Route::put('{role:id}', UpdateController::class)
            ->withTrashed()
            ->middleware('can:update_admin__roles,App\Models\Admin\User');
    });
