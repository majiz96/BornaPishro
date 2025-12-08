<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Livewire\Counter;
use App\Livewire\Parts\Navbar;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Dashboard;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('counter',Counter::class)->name('counter');
Route::get('register',Register::class)->name('register');
Route::get('login',Login::class)->name('login');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard',Dashboard::class)->name('dashboard');
});
