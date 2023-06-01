<?php

Route::prefix('users')
    ->namespace('User')
    ->group(function () {
        Route::get('', ListController::class)
            ->middleware('can:view_user,App\Models\Admin\User')
            ->name('user');

        Route::get('create', CreateController::class)
            ->middleware('can:create_user,App\Models\Admin\User')
            ->name('user.create');
        Route::post('create', StoreController::class)
            ->middleware('can:create_user,App\Models\Admin\User');

        Route::get('{user:id}', ShowController::class)
            ->withTrashed()
            ->middleware('can:view_user,App\Models\Admin\User')
            ->name('user.show');
        Route::put('{user:id}', UpdateController::class)
            ->withTrashed()
            ->middleware('can:update_user,App\Models\Admin\User');
        Route::delete('{user:id}', DeleteController::class)
            ->withTrashed()
            ->middleware('can:delete_user,App\Models\Admin\User');
    });
