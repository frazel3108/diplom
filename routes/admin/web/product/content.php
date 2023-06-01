<?php

Route::prefix('products/content')
    ->namespace('Product\Content')
    ->group(function () {
        Route::get('', ListController::class)
            ->middleware('can:view_products_content,App\Models\Admin\User')
            ->name('products.content');

        Route::get('create', CreateController::class)
            ->middleware('can:create_products_content,App\Models\Admin\User')
            ->name('products.content.create');
        Route::post('create', StoreController::class)
            ->middleware('can:create_products_content,App\Models\Admin\User');

        Route::get('{content:id}', ShowController::class)
            ->withTrashed()
            ->middleware('can:view_products_content,App\Models\Admin\User')
            ->name('products.content.show');
        Route::put('{content:id}', UpdateController::class)
            ->withTrashed()
            ->middleware('can:update_products_content,App\Models\Admin\User');
        Route::delete('{content:id}', DeleteController::class)
            ->withTrashed()
            ->middleware('can:delete_products_content,App\Models\Admin\User');
    });
