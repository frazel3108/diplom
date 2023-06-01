<?php

Route::prefix('category')
    ->namespace('Category')
    ->group(function () {
        Route::get('', ListController::class)
            ->middleware('can:view_category,App\Models\Admin\User')
            ->name('category');

        Route::get('create', CreateController::class)
            ->middleware('can:create_category,App\Models\Admin\User')
            ->name('category.create');
        Route::post('create', StoreController::class)
            ->middleware('can:create_category,App\Models\Admin\User');

        Route::get('{category:id}', ShowController::class)
            ->withTrashed()
            ->middleware('can:view_category,App\Models\Admin\User')
            ->name('category.show');
        Route::put('{category:id}', UpdateController::class)
            ->withTrashed()
            ->middleware('can:update_category,App\Models\Admin\User');
        Route::delete('{category:id}', DeleteController::class)
            ->withTrashed()
            ->middleware('can:delete_category,App\Models\Admin\User');
    });
