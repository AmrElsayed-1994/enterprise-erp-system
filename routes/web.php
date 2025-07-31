<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware('auth')->prefix('modules')->group(function () {
    Route::get('/real-estate', function () {
        return view('modules.real-estate.dashboard');
    })->name('real-estate.dashboard');
    
    Route::get('/technical-office', function () {
        return view('modules.technical-office.dashboard');
    })->name('technical-office.dashboard');
    
    Route::get('/contracts', function () {
        return view('modules.contracts.dashboard');
    })->name('contracts.dashboard');
    
    Route::get('/financial', function () {
        return view('modules.financial.dashboard');
    })->name('financial.dashboard');
    
    Route::get('/assets', function () {
        return view('modules.assets.dashboard');
    })->name('assets.dashboard');
    
    Route::get('/purchases', function () {
        return view('modules.purchases.dashboard');
    })->name('purchases.dashboard');
    
    Route::get('/hr', function () {
        return view('modules.hr.dashboard');
    })->name('hr.dashboard');
    
    Route::get('/maintenance', function () {
        return view('modules.maintenance.dashboard');
    })->name('maintenance.dashboard');
    
    Route::get('/partners', function () {
        return view('modules.partners.dashboard');
    })->name('partners.dashboard');
    
    Route::get('/documents', function () {
        return view('modules.documents.dashboard');
    })->name('documents.dashboard');
    
    Route::get('/secretarial', function () {
        return view('modules.secretarial.dashboard');
    })->name('secretarial.dashboard');
    
    Route::get('/public-admin', function () {
        return view('modules.public-admin.dashboard');
    })->name('public-admin.dashboard');
    
    Route::get('/subcontractors', function () {
        return view('modules.subcontractors.dashboard');
    })->name('subcontractors.dashboard');
    
    Route::get('/reports', function () {
        return view('modules.reports.dashboard');
    })->name('reports.dashboard');
    
    Route::get('/risk-management', function () {
        return view('modules.risk-management.dashboard');
    })->name('risk-management.dashboard');
    
    Route::get('/health-safety', function () {
        return view('modules.health-safety.dashboard');
    })->name('health-safety.dashboard');
    
    Route::get('/system-settings', function () {
        return view('modules.system-settings.dashboard');
    })->name('system-settings.dashboard');
    
    Route::get('/user-management', function () {
        return view('modules.user-management.dashboard');
    })->name('user-management.dashboard');
});
