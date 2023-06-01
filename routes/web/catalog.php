<?php

Route::prefix('/catalog')
    ->name('catalog.')
    ->group(function() {
        Route::get('', Catalog\ListController::class)->name('list');

        require 'category.php';
    });