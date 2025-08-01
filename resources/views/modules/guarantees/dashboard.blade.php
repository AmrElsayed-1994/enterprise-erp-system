@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0">
                        <i class="fas fa-shield-alt me-2 text-primary"></i>
                        {{ auth()->user()->preferred_language == 'ar' ? 'إدارة الضمانات' : 'Guarantees Management' }}
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ auth()->user()->preferred_language == 'ar' ? 'الرئيسية' : 'Dashboard' }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('modules.subcontractors') }}">{{ auth()->user()->preferred_language == 'ar' ? 'المقاولين' : 'Subcontractors' }}</a></li>
                            <li class="breadcrumb-item active">{{ auth()->user()->preferred_language == 'ar' ? 'الضمانات' : 'Guarantees' }}</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('guarantees.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>
                        {{ auth()->user()->preferred_language == 'ar' ? 'إضافة ضمان' : 'Add Guarantee' }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-opacity-10 p-3 rounded">
                                <i class="fas fa-shield-alt text-primary fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">{{ auth()->user()->preferred_language == 'ar' ? 'إجمالي الضمانات' : 'Total Guarantees' }}</h6>
                            <h3 class="mb-0">{{ $totalGuarantees ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success bg-opacity-10 p-3 rounded">
                                <i class="fas fa-check-circle text-success fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">{{ auth()->user()->preferred_language == 'ar' ? 'الضمانات النشطة' : 'Active Guarantees' }}</h6>
                            <h3 class="mb-0">{{ $activeGuarantees ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-warning bg-opacity-10 p-3 rounded">
                                <i class="fas fa-exclamation-triangle text-warning fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">{{ auth()->user()->preferred_language == 'ar' ? 'تنتهي خلال 30 يوم' : 'Expiring in 30 Days' }}</h6>
                            <h3 class="mb-0">{{ $expiringGuarantees ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-info bg-opacity-10 p-3 rounded">
                                <i class="fas fa-dollar-sign text-info fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">{{ auth()->user()->preferred_language == 'ar' ? 'إجمالي القيمة' : 'Total Value' }}</h6>
                            <h3 class="mb-0">${{ number_format($totalValue ?? 0, 0) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list me-2"></i>
                        {{ auth()->user()->preferred_language == 'ar' ? 'قائمة الضمانات' : 'Guarantees List' }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <div>
                            <a href="{{ route('guarantees.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-list me-2"></i>
                                {{ auth()->user()->preferred_language == 'ar' ? 'عرض جميع الضمانات' : 'View All Guarantees' }}
                            </a>
                        </div>
                        <div>
                            <a href="{{ route('guarantees.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>
                                {{ auth()->user()->preferred_language == 'ar' ? 'إضافة ضمان جديد' : 'Add New Guarantee' }}
                            </a>
                        </div>
                    </div>
                    <div class="text-center py-5">
                        <i class="fas fa-shield-alt display-1 text-muted mb-3"></i>
                        <h4 class="text-muted">{{ auth()->user()->preferred_language == 'ar' ? 'إدارة الضمانات' : 'Guarantees Management' }}</h4>
                        <p class="text-muted">{{ auth()->user()->preferred_language == 'ar' ? 'إدارة شاملة للضمانات المصرفية والكفالات وتتبع انتهاء الصلاحية' : 'Comprehensive management of bank guarantees, bonds and expiry tracking' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
