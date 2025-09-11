<?php

use App\Livewire\ExpenseReports\AllExpenseReports;
use App\Livewire\ExpenseReports\CreateExpenseReport;
use App\Livewire\ExpenseReports\MyExpenseReports;
use App\Livewire\Users\CreateUser;
use App\Livewire\Users\UserProfile;
use App\Livewire\Auth\ChangePassword;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

// Route pour changer le mot de passe (accessible même si must_change_password = true)
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/change-password', ChangePassword::class)->name('password.change');
});

// Routes principales avec middleware de changement de mot de passe forcé
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'force.password.change'
])->group(function () {

    // Redirection du dashboard
    Route::get('/dashboard', function () {
        return redirect('/my-expense-reports');
    })->name('dashboard');

    // Routes communes (accessibles à tous les utilisateurs connectés)
    Route::get('/my-expense-reports', MyExpenseReports::class)->name('my-expense-reports');
    Route::get('/create-expense-report', CreateExpenseReport::class)->name('create-expense-report');
    Route::get('/user-profile', UserProfile::class)->name('user-profile');

    // Routes Manager/Comptabilité
    Route::middleware('role:manager|accounting')->group(function () {
        Route::get('/all-expense-reports', AllExpenseReports::class)->name('all-expense-reports');
    });

    // Routes Manager uniquement
    Route::middleware('role:manager')->group(function () {
        Route::get('/create-user', CreateUser::class)->name('create-user');
    });
});
