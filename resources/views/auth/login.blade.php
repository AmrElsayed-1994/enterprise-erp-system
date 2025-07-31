@extends('layouts.app')

@section('content')
<div class="container-fluid vh-100">
    <div class="row h-100">
        <div class="col-md-6 d-none d-md-flex align-items-center justify-content-center bg-primary">
            <div class="text-center text-white">
                <i class="fas fa-building display-1 mb-4"></i>
                <h1 class="display-4 fw-bold mb-3">Enterprise ERP</h1>
                <p class="lead">Comprehensive Business Management Solution</p>
                <p class="fs-5">نظام إدارة الموارد المؤسسية الشامل</p>
            </div>
        </div>
        
        <div class="col-md-6 d-flex align-items-center justify-content-center">
            <div class="card shadow-lg border-0" style="width: 100%; max-width: 400px;">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="fas fa-user-circle display-4 text-primary mb-3"></i>
                        <h3 class="card-title">Sign In</h3>
                        <p class="text-muted">تسجيل الدخول</p>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email') }}" required autofocus>
                            </div>
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password" required>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">
                                Remember me
                            </label>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-sign-in-alt me-2"></i>Sign In
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <p class="text-muted">
                            Don't have an account? 
                            <a href="{{ route('register') }}" class="text-decoration-none">Register here</a>
                        </p>
                    </div>

                    <div class="mt-4 p-3 bg-light rounded">
                        <h6 class="text-center mb-2">Demo Accounts</h6>
                        <small class="text-muted d-block">
                            <strong>Super Admin:</strong> superadmin@erp.com / password<br>
                            <strong>Admin:</strong> admin@erp.com / password<br>
                            <strong>Demo User:</strong> demo@erp.com / password
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
