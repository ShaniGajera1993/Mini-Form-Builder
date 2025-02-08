<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('form-builder', 'form-builder')
->middleware(['auth', 'verified'])
    ->name('form-builder');

require __DIR__.'/auth.php';
