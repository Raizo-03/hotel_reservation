<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\AdminController;

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\HotelController;



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
Route::get('/billing', [ReservationController::class, 'showBilling'])->name('billing.show');

//Admin side routers

Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('admin/reservations', [AdminController::class, 'reservations'])->name('admin.reservations.index');
Route::get('admin/reservations/delete/{id}', [AdminController::class, 'deleteReservation'])->name('admin.reservations.delete');
Route::get('admin/contacts', [AdminController::class, 'contacts'])->name('admin.contacts.index');
Route::get('admin/hotels', [AdminController::class, 'hotels'])->name('admin.hotels.index');
Route::post('admin/hotels/store', [AdminController::class, 'storeHotel'])->name('admin.hotels.store');
Route::get('admin/hotels/delete/{id}', [AdminController::class, 'deleteHotel'])->name('admin.hotels.delete');

Route::get('hotel/admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('hotel/admin/login', [AuthController::class, 'login'])->name('admin.login.post');
Route::get('hotel/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

Route::prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Reservations
    Route::get('/reservations', [AdminController::class, 'reservations'])->name('reservations.index');
    Route::get('/reservations/delete/{id}', [AdminController::class, 'deleteReservation'])->name('reservations.delete');
    
    // Contacts
    Route::get('/contacts', [AdminController::class, 'contacts'])->name('contacts.index');
    
    // Hotels - Using HotelController
    Route::get('/hotels', [HotelController::class, 'index'])->name('hotels.index');
    Route::post('/hotels/store', [HotelController::class, 'store'])->name('hotels.store');
    Route::get('/hotels/edit/{id}', [HotelController::class, 'edit'])->name('hotels.edit');
    Route::post('/hotels/update/{id}', [HotelController::class, 'update'])->name('hotels.update');
    Route::get('/hotels/delete/{id}', [HotelController::class, 'destroy'])->name('hotels.delete');
});
Route::get('/fetch-reservations-data', [AdminController::class, 'fetchReservationsData'])->name('admin.fetch-reservations-data');
