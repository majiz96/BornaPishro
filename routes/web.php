<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Counter;

use App\Livewire\Products;
use App\Livewire\ProductUnit;
use App\Livewire\Services;
use App\Livewire\ServiceUnit;
use App\Livewire\Articles;
use App\Livewire\ArticleUnit;

use App\Livewire\Dashboard\Users\EditProfile;
use App\Livewire\Dashboard\Users\UsersManagement;
use App\Livewire\Dashboard\Users\MyProducts;
use App\Livewire\Dashboard\Website\Info;
use App\Livewire\Dashboard\Website\Socials;
use App\Livewire\Dashboard\Website\Licenses;
use App\Livewire\Dashboard\Website\Categories;
use App\Livewire\Dashboard\Website\Filters;
use App\Livewire\Dashboard\Website\Communications;
use App\Livewire\Dashboard\Website\Notices;
use App\Livewire\Dashboard\Products\ProductsManagement;
use App\Livewire\Dashboard\Products\Brands;
use App\Livewire\Dashboard\Products\Discounts;
use App\Livewire\Dashboard\ArticlesManagement;
use App\Livewire\Dashboard\ServicesManagement;

use App\Livewire\Parts\Messages;

use App\Livewire\Dashboard\Attachments\Files;
use App\Livewire\Dashboard\Attachments\Galleries;
use App\Livewire\Dashboard\Attachments\Videos;
use App\Livewire\Dashboard\Attachments\Sources;
use App\Livewire\Dashboard\Attachments\Briefs;
use App\Livewire\Dashboard\Attachments\Specifications;
use App\Livewire\Dashboard\Attachments\Comments;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('counter',Counter::class)->name('counter');
Route::get('register',Register::class)->name('register');
Route::get('login',Login::class)->name('login');


Route::get('products',Products::class)->name('products');
Route::get('products/{category}',Products::class)->name('products.category');
Route::get('product/{product}',ProductUnit::class)->name('product.show');
Route::get('services',Services::class)->name('services');
Route::get('services/{category}',Services::class)->name('services.category');
Route::get('service/{service}',ServiceUnit::class)->name('service.show');
Route::get('articles',Articles::class)->name('articles');
Route::get('articles/{category}',Articles::class)->name('articles.category');
Route::get('article/{article}',ArticleUnit::class)->name('article.show');


Route::middleware(['auth', 'verified'])->prefix('dashboard')->group(function () {

    //users routes
    Route::get('profile',EditProfile::class)->name('profile');
    Route::get('users',UsersManagement::class)->name('users');
    Route::get('my-products',MyProducts::class)->name('my-products');

    //website routes
    Route::get('info',Info::class)->name('info');
    Route::get('social',Socials::class)->name('social');
    Route::get('licences',Licenses::class)->name('licenses');
    Route::get('categories',Categories::class)->name('categories');
    Route::get('filters',Filters::class)->name('filters');
    Route::get('notices',Notices::class)->name('notices');
    Route::get('comms',Communications::class)->name('comms');

    //products routes
    Route::get('products-management',ProductsManagement::class)->name('products-management');
    Route::get('brands',Brands::class)->name('brands');
    Route::get('discounts',Discounts::class)->name('discounts');

    Route::get('/messages/{notice?}',Messages::class)->name('messages.show');

    Route::get('files/{product}',Files::class)->name('files.show');
    Route::get('galleries/{product}',Galleries::class)->name('galleries.show');
    Route::get('videos/{product}',Videos::class)->name('videos.show');
    Route::get('sources/{product}',Sources::class)->name('sources.show');
    Route::get('briefs/{product}',Briefs::class)->name('briefs.show');
    Route::get('specifications/{product}',Specifications::class)->name('specifications.show');
    Route::get('comments/{type}/{id}',Comments::class)->name('comments');

    Route::get('articles-management',ArticlesManagement::class)->name('articles-management');

    Route::get('services-management',ServicesManagement::class)->name('services-management');
});
