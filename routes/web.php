<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::prefix('mary-ui')->name('mary-ui.')->group(function () {
    Volt::route('users', 'pages.mary-ui.users.index')->name('users.index');
    Volt::route('users/create', 'pages.mary-ui.users.create')->name('users.create');
    Volt::route('users/{id}/edit', 'pages.mary-ui.users.edit')->name('users.edit');
    Volt::route('users/{id}/biodata', 'pages.mary-ui.users.biodata')->name('users.biodata');
});

Route::prefix('daisy-ui')->name('daisy-ui.')->group(function () {
    Volt::route('users', 'pages.daisy-ui.users.index')->name('users.index');
    Volt::route('users/create', 'pages.daisy-ui.users.create')->name('users.create');
    Volt::route('users/{id}/edit', 'pages.daisy-ui.users.edit')->name('users.edit');
    Volt::route('users/{id}/biodata', 'pages.daisy-ui.users.biodata')->name('users.biodata');
});

Route::prefix('articles')->name('articles.')->group(function () {
    Volt::route('/', 'pages.articles.index')->name('index');
    Volt::route('/create', 'pages.articles.create')->name('create');
    Volt::route('/{id}/edit', 'pages.articles.edit')->name('edit');
    Volt::route('/{id}/details', 'pages.articles.show')->name('show');
});
require __DIR__.'/auth.php';
