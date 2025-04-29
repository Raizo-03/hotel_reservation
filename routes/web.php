<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ReservationController;

Route::get('/', function () {
    return view('index');
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/fetch-hotels', [HomeController::class, 'fetchHotels'])->name('fetch.hotels');

Route::get('/contact', [ContactController::class, 'showForm'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/company', [CompanyController::class, 'index'])->name('company');
// For showing the reservation form (GET request)
Route::get('/reservation', [ReservationController::class, 'index'])->name('reservation');

// For submitting the reservation form (POST request)
Route::post('/reservation', [ReservationController::class, 'store'])->name('reservation.store');


