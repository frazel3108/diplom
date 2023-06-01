<?php

Route::get('/', MainController::class)->name('index');

Route::get('/support/', Support\ShowController::class)->name('support');
Route::post('/support/', Support\FormController::class);
Route::get('/about/', [App\Http\Controllers\StaticPageController::class, 'about'])->name('about');
Route::get('/warranty/', [App\Http\Controllers\StaticPageController::class, 'warranty'])->name('warranty');