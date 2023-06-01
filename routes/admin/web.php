<?php

use Illuminate\Support\Facades\Route;

Route::get('/', DashboardController::class)->name('home');

require __DIR__ . '/web/users.php';
require __DIR__ . '/web/categories.php';
require __DIR__ . '/web/products.php';
require __DIR__ . '/web/characteristics.php';
require __DIR__ . '/web/offers.php';
require __DIR__ . '/web/access.php';
require __DIR__ . '/web/orders.php';

Route::post('upload', UploadController::class)
    ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])
    ->middleware(App\Http\Middleware\VerifyCkEditorCsrfToken::class)
    ->name('upload');