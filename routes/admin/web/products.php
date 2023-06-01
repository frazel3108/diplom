<?php

Route::prefix('product')
    ->namespace('Product')
    ->group(function () {
        Route::get('', ListController::class)
            ->middleware('can:view_product,App\Models\Admin\User')
            ->name('product');

        Route::get('create', CreateController::class)
            ->middleware('can:create_product,App\Models\Admin\User')
            ->name('product.create');
        Route::post('create', StoreController::class)
            ->middleware('can:create_product,App\Models\Admin\User');

        Route::get('{product:id}', ShowController::class)
            ->withTrashed()
            ->middleware('can:view_product,App\Models\Admin\User')
            ->name('product.show');
        Route::put('{product:id}', UpdateController::class)
            ->withTrashed()
            ->middleware('can:update_product,App\Models\Admin\User');
        Route::delete('{product:id}', DeleteController::class)
            ->withTrashed()
            ->middleware('can:delete_product,App\Models\Admin\User');

    });

require __DIR__ . '/product/content.php';