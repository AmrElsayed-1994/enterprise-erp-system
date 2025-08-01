<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ContractorItemsController;
use App\Http\Controllers\ContractorTendersController;
use App\Http\Controllers\PaymentCertificatesController;
use App\Http\Controllers\GuaranteesController;
use App\Http\Controllers\ProductionLaborController;
use App\Http\Controllers\ChangeOrdersController;
use App\Http\Controllers\ContractorMonitoringController;
use App\Http\Controllers\ContractorReportsController;

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
    
    Route::prefix('subcontractors')->group(function () {
        Route::get('/contractor-items', [ContractorItemsController::class, 'dashboard'])->name('contractor-items.dashboard');
        Route::resource('contractor-items', ContractorItemsController::class);

        Route::get('/contractor-tenders', [ContractorTendersController::class, 'dashboard'])->name('contractor-tenders.dashboard');
        Route::resource('contractor-tenders', ContractorTendersController::class);

        Route::get('/payment-certificates', [PaymentCertificatesController::class, 'dashboard'])->name('payment-certificates.dashboard');
        Route::resource('payment-certificates', PaymentCertificatesController::class);

        Route::get('/guarantees', [GuaranteesController::class, 'dashboard'])->name('guarantees.dashboard');
        Route::resource('guarantees', GuaranteesController::class);

        Route::get('/production-labor', [ProductionLaborController::class, 'dashboard'])->name('production-labor.dashboard');
        Route::resource('production-labor', ProductionLaborController::class);

        Route::get('/change-orders', [ChangeOrdersController::class, 'dashboard'])->name('change-orders.dashboard');
        Route::resource('change-orders', ChangeOrdersController::class);

        Route::get('/contractor-monitoring', [ContractorMonitoringController::class, 'dashboard'])->name('contractor-monitoring.dashboard');
        Route::resource('contractor-monitoring', ContractorMonitoringController::class);

        Route::get('/contractor-reports', [ContractorReportsController::class, 'dashboard'])->name('contractor-reports.dashboard');
        Route::resource('contractor-reports', ContractorReportsController::class);
        Route::post('/contractor-reports/{contractorReport}/generate', [ContractorReportsController::class, 'generate'])->name('contractor-reports.generate');
    });
    
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
