@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0">
                        <i class="fas fa-hard-hat me-2 text-primary"></i>
                        {{ auth()->user()->preferred_language == 'ar' ? 'عمال الإنتاج' : 'Production Labor' }}
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ auth()->user()->preferred_language == 'ar' ? 'الرئيسية' : 'Dashboard' }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('modules.subcontractors') }}">{{ auth()->user()->preferred_language == 'ar' ? 'المقاولين' : 'Subcontractors' }}</a></li>
                            <li class="breadcrumb-item active">{{ auth()->user()->preferred_language == 'ar' ? 'عمال الإنتاج' : 'Production Labor' }}</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('production-labor.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>
                        {{ auth()->user()->preferred_language == 'ar' ? 'إضافة عامل' : 'Add Worker' }}
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
                                <i class="fas fa-users text-primary fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">{{ auth()->user()->preferred_language == 'ar' ? 'إجمالي العمال' : 'Total Workers' }}</h6>
                            <h3 class="mb-0">{{ $totalWorkers ?? 0 }}</h3>
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
                                <i class="fas fa-user-check text-success fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">{{ auth()->user()->preferred_language == 'ar' ? 'العمال النشطين' : 'Active Workers' }}</h6>
                            <h3 class="mb-0">{{ $activeWorkers ?? 0 }}</h3>
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
                                <i class="fas fa-chart-line text-warning fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">{{ auth()->user()->preferred_language == 'ar' ? 'متوسط الإنتاجية' : 'Avg Productivity' }}</h6>
                            <h3 class="mb-0">{{ number_format($avgProductivity ?? 0, 1) }}%</h3>
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
                                <i class="fas fa-clock text-info fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">{{ auth()->user()->preferred_language == 'ar' ? 'إجمالي ساعات العمل' : 'Total Hours Worked' }}</h6>
                            <h3 class="mb-0">{{ number_format($totalHours ?? 0) }}</h3>
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
                        {{ auth()->user()->preferred_language == 'ar' ? 'قائمة العمال' : 'Workers List' }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <div>
                            <a href="{{ route('production-labor.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-list me-2"></i>
                                {{ auth()->user()->preferred_language == 'ar' ? 'عرض جميع العمال' : 'View All Workers' }}
                            </a>
                        </div>
                        <div>
                            <a href="{{ route('production-labor.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>
                                {{ auth()->user()->preferred_language == 'ar' ? 'إضافة عامل جديد' : 'Add New Worker' }}
                            </a>
                        </div>
                    </div>
                    <div class="text-center py-5">
                        <i class="fas fa-hard-hat display-1 text-muted mb-3"></i>
                        <h4 class="text-muted">{{ auth()->user()->preferred_language == 'ar' ? 'إدارة عمال الإنتاج' : 'Production Labor Management' }}</h4>
                        <p class="text-muted">{{ auth()->user()->preferred_language == 'ar' ? 'إدارة شاملة للعمالة وتخصيص المهارات وتتبع الإنتاجية' : 'Comprehensive labor management, skill allocation and productivity tracking' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
