<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Counter;

use App\Livewire\Dashboard\Users\EditProfile;
use App\Livewire\Dashboard\Users\UsersManagement;
use App\Livewire\Dashboard\Website\Info;
use App\Livewire\Dashboard\Website\Social;
use App\Livewire\Dashboard\Website\Licenses;
use App\Livewire\Dashboard\Website\Categories;
use App\Livewire\Dashboard\Website\Communications;
use App\Livewire\Dashboard\Products\Products;
use App\Livewire\Dashboard\Products\Brands;
use App\Livewire\Dashboard\Articles;
use App\Livewire\Dashboard\Services;




Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('counter',Counter::class)->name('counter');
Route::get('register',Register::class)->name('register');
Route::get('login',Login::class)->name('login');


Route::middleware(['auth', 'verified'])->prefix('dashboard')->group(function () {

    //users routes
    Route::get('profile',EditProfile::class)->name('profile');
    Route::get('users',UsersManagement::class)->name('users');

    //website routes
    Route::get('info',Info::class)->name('info');
    Route::get('social',Social::class)->name('social');
    Route::get('licences',Licenses::class)->name('licenses');
    Route::get('categories',Licenses::class)->name('categories');
    Route::get('comms',Communications::class)->name('comms');

    //products routes
    Route::get('products',Products::class)->name('products');
    Route::get('brands',Brands::class)->name('brands');

    Route::get('articles',Articles::class)->name('articles');

    Route::get('services',Services::class)->name('services');
});
