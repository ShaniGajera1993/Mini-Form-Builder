<?php

use App\Livewire\FormBuilder;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/form-builder', FormBuilder::class)
    ->middleware(['auth'])
    ->name('form-builder');

require __DIR__.'/auth.php';
