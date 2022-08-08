<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\Frontend\OrderController;

;
use App\Models\Blog;
use App\Models\Program;
use Illuminate\Support\Facades\Crypt;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Payment Route
Route::get('/payment', function () {
    return Inertia::render('Frontend/Payment');
});

Route::get('/payment/{id}', [OrderController::class, 'paymentOrder'])->name('order.payment');
Route::post('/payment/confirmation', [OrderController::class, 'confirmPayment'])->name('order.payment.confirm');






