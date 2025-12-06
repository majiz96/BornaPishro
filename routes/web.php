<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Livewire\Counter;
use App\Livewire\Parts\Navbar;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('counter',Counter::class)->name('counter');
