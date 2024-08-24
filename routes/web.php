<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::group(['middleware' => 'guest'],function(){
    Route::get('login', function () { return view('auth/login'); })->name('login');
    Route::get('register', function () { return view('auth/register'); })->name('register')->middleware('guest');
    Route::post('postlogin', [AuthController::class, 'login'])->name('postlogin');
    Route::post('postregister', [AuthController::class, 'register'])->name('postregister');
});

Route::group(['middleware' => 'auth'],function(){
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});

Route::group(['middleware' => 'auth.organizer'],function(){
    Route::get('home',[DashboardController::class , 'index'])->name('dashboard');

    Route::get('event/export', [EventController::class, 'export'])->name('event.export');
    Route::resource('event', EventController::class);
    Route::post('event/cancel/{event}', [EventController::class, 'cancel'])->name('event.cancel');
});

Route::group(['middleware' => 'auth.attendee'],function(){
    Route::get('tickets/checkout/success/{session_id}', [TicketController::class, 'success'])->name('checkout.success');
    Route::post('tickets/comment/{event}', [TicketController::class, 'saveComment'])->name('ticket.comment');
    Route::get('tickets', [TicketController::class, 'index'])->name('ticket.index');
    Route::get('tickets/view/{event}', [TicketController::class, 'view'])->name('ticket.view');
    Route::get('tickets/purchase/{event}', [TicketController::class, 'purchase'])->name('ticket.purchase');
    Route::get('tickets/checkout/{event}/{plan}', [TicketController::class, 'checkout'])->name('ticket.checkout');
    Route::get('tickets/purchase/{event}', [TicketController::class, 'purchase'])->name('ticket.purchase');
    Route::get('tickets/checkout/cancel', [TicketController::class, 'cancel'])->name('checkout.cancel');
});
