@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0">
                        {{ $user->preferred_language == 'ar' ? 'لوحة التحكم الرئيسية' : 'Main Dashboard' }}
                    </h1>
                    <p class="text-muted mb-0">
                        {{ $user->preferred_language == 'ar' ? 'مرحباً بك، ' . $user->name : 'Welcome back, ' . $user->name }}
                    </p>
                </div>
                <div class="text-end">
                    <small class="text-muted">
                        {{ $user->preferred_language == 'ar' ? 'آخر تسجيل دخول' : 'Last login' }}: 
                        {{ now()->format('M d, Y H:i') }}
                    </small>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-th-large me-2 text-primary"></i>
                        {{ $user->preferred_language == 'ar' ? 'وحدات النظام' : 'System Modules' }}
                    </h5>
                </div>
                <div class="card-body p-4">
                    @if($accessibleModules->count() > 0)
                        <div class="row g-4">
                            @foreach($accessibleModules as $module)
                                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                                    <div class="card module-card h-100 text-center p-4" 
                                         onclick="window.location.href='{{ route($module['route']) }}'">
                                        <div class="card-body d-flex flex-column justify-content-center">
                                            <div class="module-icon">
                                                <i class="fas fa-{{ $module['icon'] }}"></i>
                                            </div>
                                            <h5 class="card-title mb-2">
                                                {{ $user->preferred_language == 'ar' ? $module['name_ar'] : $module['name_en'] }}
                                            </h5>
                                            <p class="card-text text-muted small">
                                                {{ $user->preferred_language == 'ar' ? $module['name_en'] : $module['name_ar'] }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-lock display-1 text-muted mb-3"></i>
                            <h4 class="text-muted">
                                {{ $user->preferred_language == 'ar' ? 'لا توجد وحدات متاحة' : 'No Modules Available' }}
                            </h4>
                            <p class="text-muted">
                                {{ $user->preferred_language == 'ar' ? 'يرجى الاتصال بالمدير لتعيين الصلاحيات المناسبة' : 'Please contact your administrator to assign appropriate permissions' }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if($user->hasRole('super_admin') || $user->hasRole('admin'))
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-line me-2 text-success"></i>
                        {{ $user->preferred_language == 'ar' ? 'نظرة عامة سريعة' : 'Quick Overview' }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center">
                                    <i class="fas fa-users display-4 mb-2"></i>
                                    <h4>{{ \App\Models\User::count() }}</h4>
                                    <p class="mb-0">{{ $user->preferred_language == 'ar' ? 'المستخدمين' : 'Users' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <i class="fas fa-shield-alt display-4 mb-2"></i>
                                    <h4>{{ \App\Models\Role::count() }}</h4>
                                    <p class="mb-0">{{ $user->preferred_language == 'ar' ? 'الأدوار' : 'Roles' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body text-center">
                                    <i class="fas fa-key display-4 mb-2"></i>
                                    <h4>{{ \App\Models\Permission::count() }}</h4>
                                    <p class="mb-0">{{ $user->preferred_language == 'ar' ? 'الصلاحيات' : 'Permissions' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body text-center">
                                    <i class="fas fa-th-large display-4 mb-2"></i>
                                    <h4>{{ $accessibleModules->count() }}</h4>
                                    <p class="mb-0">{{ $user->preferred_language == 'ar' ? 'الوحدات المتاحة' : 'Available Modules' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
