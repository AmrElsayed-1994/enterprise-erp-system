@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0">
                        <i class="fas fa-hard-hat me-2 text-primary"></i>
                        {{ auth()->user()->preferred_language == 'ar' ? 'المقاولين من الباطن' : 'Subcontractors Management' }}
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ auth()->user()->preferred_language == 'ar' ? 'الرئيسية' : 'Dashboard' }}</a></li>
                            <li class="breadcrumb-item active">{{ auth()->user()->preferred_language == 'ar' ? 'المقاولين من الباطن' : 'Subcontractors' }}</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <button class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>
                        {{ auth()->user()->preferred_language == 'ar' ? 'إضافة مقاول' : 'Add Subcontractor' }}
                    </button>
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
                            <h6 class="text-muted mb-1">{{ auth()->user()->preferred_language == 'ar' ? 'إجمالي المقاولين' : 'Total Subcontractors' }}</h6>
                            <h3 class="mb-0">24</h3>
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
                                <i class="fas fa-star text-success fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">{{ auth()->user()->preferred_language == 'ar' ? 'متوسط الأداء' : 'Performance Score' }}</h6>
                            <h3 class="mb-0">4.2/5</h3>
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
                            <h6 class="text-muted mb-1">{{ auth()->user()->preferred_language == 'ar' ? 'نسبة التسليم في الوقت' : 'On-time Delivery' }}</h6>
                            <h3 class="mb-0">89%</h3>
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
                                <i class="fas fa-dollar-sign text-warning fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">{{ auth()->user()->preferred_language == 'ar' ? 'نسبة الدفع في الوقت' : 'On-time Payment' }}</h6>
                            <h3 class="mb-0">95%</h3>
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
                        {{ auth()->user()->preferred_language == 'ar' ? 'قائمة المقاولين' : 'Subcontractors List' }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('contractor-items.dashboard') }}" class="text-decoration-none">
                                <div class="card border-0 shadow-sm h-100 hover-card">
                                    <div class="card-body text-center">
                                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle d-inline-flex mb-3">
                                            <i class="fas fa-list-alt text-primary fs-2"></i>
                                        </div>
                                        <h5 class="card-title">{{ auth()->user()->preferred_language == 'ar' ? 'مكتبة البنود الرئيسية' : 'Item Master Library' }}</h5>
                                        <p class="card-text text-muted">{{ auth()->user()->preferred_language == 'ar' ? 'إدارة كتالوج البنود والمواد' : 'Manage items and materials catalog' }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('contractor-tenders.dashboard') }}" class="text-decoration-none">
                                <div class="card border-0 shadow-sm h-100 hover-card">
                                    <div class="card-body text-center">
                                        <div class="bg-success bg-opacity-10 p-3 rounded-circle d-inline-flex mb-3">
                                            <i class="fas fa-gavel text-success fs-2"></i>
                                        </div>
                                        <h5 class="card-title">{{ auth()->user()->preferred_language == 'ar' ? 'العقود والمناقصات' : 'Contracts & Tenders' }}</h5>
                                        <p class="card-text text-muted">{{ auth()->user()->preferred_language == 'ar' ? 'إدارة المناقصات والعقود' : 'Manage tenders and contracts' }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('payment-certificates.dashboard') }}" class="text-decoration-none">
                                <div class="card border-0 shadow-sm h-100 hover-card">
                                    <div class="card-body text-center">
                                        <div class="bg-warning bg-opacity-10 p-3 rounded-circle d-inline-flex mb-3">
                                            <i class="fas fa-file-invoice-dollar text-warning fs-2"></i>
                                        </div>
                                        <h5 class="card-title">{{ auth()->user()->preferred_language == 'ar' ? 'شهادات الدفع' : 'Payment Certificates' }}</h5>
                                        <p class="card-text text-muted">{{ auth()->user()->preferred_language == 'ar' ? 'إدارة المستخلصات والفواتير' : 'Manage payment certificates' }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('guarantees.dashboard') }}" class="text-decoration-none">
                                <div class="card border-0 shadow-sm h-100 hover-card">
                                    <div class="card-body text-center">
                                        <div class="bg-info bg-opacity-10 p-3 rounded-circle d-inline-flex mb-3">
                                            <i class="fas fa-shield-alt text-info fs-2"></i>
                                        </div>
                                        <h5 class="card-title">{{ auth()->user()->preferred_language == 'ar' ? 'إدارة الضمانات' : 'Guarantees Management' }}</h5>
                                        <p class="card-text text-muted">{{ auth()->user()->preferred_language == 'ar' ? 'إدارة الضمانات والكفالات' : 'Manage guarantees and bonds' }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('production-labor.dashboard') }}" class="text-decoration-none">
                                <div class="card border-0 shadow-sm h-100 hover-card">
                                    <div class="card-body text-center">
                                        <div class="bg-danger bg-opacity-10 p-3 rounded-circle d-inline-flex mb-3">
                                            <i class="fas fa-hard-hat text-danger fs-2"></i>
                                        </div>
                                        <h5 class="card-title">{{ auth()->user()->preferred_language == 'ar' ? 'عمال الإنتاج' : 'Production Labor' }}</h5>
                                        <p class="card-text text-muted">{{ auth()->user()->preferred_language == 'ar' ? 'إدارة العمالة والإنتاجية' : 'Manage labor and productivity' }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('change-orders.dashboard') }}" class="text-decoration-none">
                                <div class="card border-0 shadow-sm h-100 hover-card">
                                    <div class="card-body text-center">
                                        <div class="bg-secondary bg-opacity-10 p-3 rounded-circle d-inline-flex mb-3">
                                            <i class="fas fa-exchange-alt text-secondary fs-2"></i>
                                        </div>
                                        <h5 class="card-title">{{ auth()->user()->preferred_language == 'ar' ? 'أوامر التغيير والمطالبات' : 'Change Orders & Claims' }}</h5>
                                        <p class="card-text text-muted">{{ auth()->user()->preferred_language == 'ar' ? 'إدارة التغييرات والمطالبات' : 'Manage changes and claims' }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('contractor-monitoring.dashboard') }}" class="text-decoration-none">
                                <div class="card border-0 shadow-sm h-100 hover-card">
                                    <div class="card-body text-center">
                                        <div class="bg-dark bg-opacity-10 p-3 rounded-circle d-inline-flex mb-3">
                                            <i class="fas fa-chart-line text-dark fs-2"></i>
                                        </div>
                                        <h5 class="card-title">{{ auth()->user()->preferred_language == 'ar' ? 'مراقبة المقاولين' : 'Contractor Monitoring' }}</h5>
                                        <p class="card-text text-muted">{{ auth()->user()->preferred_language == 'ar' ? 'مراقبة وتقييم الأداء' : 'Monitor and evaluate performance' }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('contractor-reports.dashboard') }}" class="text-decoration-none">
                                <div class="card border-0 shadow-sm h-100 hover-card">
                                    <div class="card-body text-center">
                                        <div class="bg-purple bg-opacity-10 p-3 rounded-circle d-inline-flex mb-3">
                                            <i class="fas fa-chart-bar text-purple fs-2"></i>
                                        </div>
                                        <h5 class="card-title">{{ auth()->user()->preferred_language == 'ar' ? 'محرك التقارير' : 'Reports Engine' }}</h5>
                                        <p class="card-text text-muted">{{ auth()->user()->preferred_language == 'ar' ? 'إنشاء وإدارة التقارير' : 'Generate and manage reports' }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
.hover-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}
.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}
.bg-purple {
    background-color: #6f42c1 !important;
}
.text-purple {
    color: #6f42c1 !important;
}
</style>
@endsection
