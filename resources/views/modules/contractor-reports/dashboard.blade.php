@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0">
                        <i class="fas fa-chart-bar me-2 text-primary"></i>
                        {{ auth()->user()->preferred_language == 'ar' ? 'محرك التقارير' : 'Reports Engine' }}
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ auth()->user()->preferred_language == 'ar' ? 'الرئيسية' : 'Dashboard' }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('modules.subcontractors') }}">{{ auth()->user()->preferred_language == 'ar' ? 'المقاولين' : 'Subcontractors' }}</a></li>
                            <li class="breadcrumb-item active">{{ auth()->user()->preferred_language == 'ar' ? 'محرك التقارير' : 'Reports Engine' }}</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('contractor-reports.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>
                        {{ auth()->user()->preferred_language == 'ar' ? 'إنشاء تقرير' : 'Create Report' }}
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
                                <i class="fas fa-file-alt text-primary fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">{{ auth()->user()->preferred_language == 'ar' ? 'إجمالي التقارير' : 'Total Reports' }}</h6>
                            <h3 class="mb-0">{{ $totalReports ?? 0 }}</h3>
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
                            <h6 class="text-muted mb-1">{{ auth()->user()->preferred_language == 'ar' ? 'التقارير المُنشأة' : 'Generated Reports' }}</h6>
                            <h3 class="mb-0">{{ $generatedReports ?? 0 }}</h3>
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
                                <i class="fas fa-calendar-alt text-warning fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">{{ auth()->user()->preferred_language == 'ar' ? 'التقارير المجدولة' : 'Scheduled Reports' }}</h6>
                            <h3 class="mb-0">{{ $scheduledReports ?? 0 }}</h3>
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
                                <i class="fas fa-stopwatch text-info fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">{{ auth()->user()->preferred_language == 'ar' ? 'متوسط وقت الإنشاء' : 'Avg Generation Time' }}</h6>
                            <h3 class="mb-0">{{ $avgGenerationTime ?? 0 }}{{ auth()->user()->preferred_language == 'ar' ? 'ث' : 's' }}</h3>
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
                        {{ auth()->user()->preferred_language == 'ar' ? 'قائمة التقارير' : 'Reports List' }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <div>
                            <a href="{{ route('contractor-reports.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-list me-2"></i>
                                {{ auth()->user()->preferred_language == 'ar' ? 'عرض جميع التقارير' : 'View All Reports' }}
                            </a>
                        </div>
                        <div>
                            <a href="{{ route('contractor-reports.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>
                                {{ auth()->user()->preferred_language == 'ar' ? 'إنشاء تقرير جديد' : 'Create New Report' }}
                            </a>
                        </div>
                    </div>
                    <div class="text-center py-5">
                        <i class="fas fa-chart-bar display-1 text-muted mb-3"></i>
                        <h4 class="text-muted">{{ auth()->user()->preferred_language == 'ar' ? 'محرك التقارير المتقدم' : 'Advanced Reports Engine' }}</h4>
                        <p class="text-muted">{{ auth()->user()->preferred_language == 'ar' ? 'إنشاء تقارير شاملة وتحليلات متقدمة عبر جميع وحدات المقاولين' : 'Generate comprehensive reports and advanced analytics across all contractor modules' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
