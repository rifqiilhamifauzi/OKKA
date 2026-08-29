<?php

use Illuminate\Support\Facades\Route;

use Inertia\Inertia;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Auth\LogoutController;

use App\Http\Controllers\PublicController;

Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/about', [PublicController::class, 'about'])->name('about');
Route::get('/program', [PublicController::class, 'program'])->name('program');
Route::get('/schedule', [PublicController::class, 'schedule'])->name('schedule');
Route::get('/announcement', [PublicController::class, 'announcement'])->name('announcement');
Route::get('/documentation', [PublicController::class, 'documentation'])->name('documentation');
Route::get('/faq', [PublicController::class, 'faq'])->name('faq');
Route::get('/registration-info', [PublicController::class, 'registrationInfo'])->name('registration.info');

Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return Inertia::render('Auth/Login');
    })->name('login');

    Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('auth.google');
    Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('auth.google.callback');
});

use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\RegistrationController;

Route::middleware('auth')->group(function () {
    Route::post('/logout', LogoutController::class)->name('logout');
    
    // User routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('user.dashboard');
    
    Route::get('/registration/create', [RegistrationController::class, 'create'])->name('registration.create');
    Route::post('/registration/store', [RegistrationController::class, 'store'])->name('registration.store');
    Route::post('/payment/upload', [RegistrationController::class, 'uploadPayment'])->name('payment.upload');

    // Push notifications
    Route::post('/push/subscribe', [\App\Http\Controllers\PushController::class, 'subscribe'])->name('push.subscribe');
    Route::post('/push/unsubscribe', [\App\Http\Controllers\PushController::class, 'unsubscribe'])->name('push.unsubscribe');
});

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\RegistrationController as AdminRegistrationController;

use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ActivityLogController;

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    
    // Registrations
    Route::get('/registrations', [AdminRegistrationController::class, 'index'])->name('registrations.index');
    Route::get('/registrations/{id}', [AdminRegistrationController::class, 'show'])->name('registrations.show');
    Route::patch('/registrations/{id}/status', [AdminRegistrationController::class, 'updateStatus'])->name('registrations.update-status');
    Route::delete('/registrations/{id}', [AdminRegistrationController::class, 'destroy'])->name('registrations.destroy');

    // Events
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
    Route::patch('/events/{event}/status', [EventController::class, 'updateStatus'])->name('events.update-status');

    // Announcements
    Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
    Route::post('/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
    Route::put('/announcements/{announcement}', [AnnouncementController::class, 'update'])->name('announcements.update');
    Route::delete('/announcements/{announcement}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');

    // Activity Logs
    Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');

    // Finances
    Route::get('/finances', [\App\Http\Controllers\Admin\FinanceController::class, 'index'])->name('finances.index');
    Route::get('/finances/export', [\App\Http\Controllers\Admin\FinanceController::class, 'export'])->name('finances.export');
});
