<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\LandingPage;
use App\Livewire\OrderPage;
use App\Livewire\MyOrdersPage;

Route::get('/', LandingPage::class)->name('home');
Route::get('/order', OrderPage::class)->name('order');
Route::get('/my-orders', MyOrdersPage::class)->name('my-orders');

Route::get('/login', function () {
    return redirect('/admin/login');
})->name('login');
