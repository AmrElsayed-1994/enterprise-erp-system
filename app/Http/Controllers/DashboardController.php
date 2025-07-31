<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        
        $modules = [
            [
                'key' => 'real_estate',
                'name_en' => 'Real Estate Investment',
                'name_ar' => 'إدارة الاستثمار العقاري',
                'icon' => 'building',
                'route' => 'real-estate.dashboard',
                'permission' => 'real_estate.view',
            ],
            [
                'key' => 'technical_office',
                'name_en' => 'Technical Office',
                'name_ar' => 'المكتب الفني',
                'icon' => 'drafting-compass',
                'route' => 'technical-office.dashboard',
                'permission' => 'technical_office.view',
            ],
            [
                'key' => 'contracts',
                'name_en' => 'Contracts Management',
                'name_ar' => 'إدارة العقود',
                'icon' => 'file-contract',
                'route' => 'contracts.dashboard',
                'permission' => 'contracts.view',
            ],
            [
                'key' => 'financial',
                'name_en' => 'Financial Management',
                'name_ar' => 'الإدارة المالية',
                'icon' => 'chart-line',
                'route' => 'financial.dashboard',
                'permission' => 'financial.view',
            ],
            [
                'key' => 'assets',
                'name_en' => 'Assets & Equipment',
                'name_ar' => 'الأصول والمعدات',
                'icon' => 'tools',
                'route' => 'assets.dashboard',
                'permission' => 'assets.view',
            ],
            [
                'key' => 'purchases',
                'name_en' => 'Purchases & Stores',
                'name_ar' => 'المشتريات والمخازن',
                'icon' => 'shopping-cart',
                'route' => 'purchases.dashboard',
                'permission' => 'purchases.view',
            ],
            [
                'key' => 'hr',
                'name_en' => 'Human Resources',
                'name_ar' => 'الموارد البشرية',
                'icon' => 'users',
                'route' => 'hr.dashboard',
                'permission' => 'hr.view',
            ],
            [
                'key' => 'maintenance',
                'name_en' => 'Maintenance & Operation',
                'name_ar' => 'الصيانة والتشغيل',
                'icon' => 'wrench',
                'route' => 'maintenance.dashboard',
                'permission' => 'maintenance.view',
            ],
            [
                'key' => 'partners',
                'name_en' => 'Partner Management',
                'name_ar' => 'إدارة الشركاء',
                'icon' => 'handshake',
                'route' => 'partners.dashboard',
                'permission' => 'partners.view',
            ],
            [
                'key' => 'documents',
                'name_en' => 'Documents & Records',
                'name_ar' => 'الوثائق والسجلات',
                'icon' => 'folder-open',
                'route' => 'documents.dashboard',
                'permission' => 'documents.view',
            ],
            [
                'key' => 'secretarial',
                'name_en' => 'Secretarial Management',
                'name_ar' => 'الإدارة السكرتارية',
                'icon' => 'calendar-alt',
                'route' => 'secretarial.dashboard',
                'permission' => 'secretarial.view',
            ],
            [
                'key' => 'public_admin',
                'name_en' => 'Public Administration',
                'name_ar' => 'الإدارة العامة',
                'icon' => 'university',
                'route' => 'public-admin.dashboard',
                'permission' => 'public_admin.view',
            ],
            [
                'key' => 'subcontractors',
                'name_en' => 'Subcontractors',
                'name_ar' => 'المقاولين من الباطن',
                'icon' => 'hard-hat',
                'route' => 'subcontractors.dashboard',
                'permission' => 'subcontractors.view',
            ],
            [
                'key' => 'reports',
                'name_en' => 'Reports Department',
                'name_ar' => 'قسم التقارير',
                'icon' => 'chart-bar',
                'route' => 'reports.dashboard',
                'permission' => 'reports.view',
            ],
            [
                'key' => 'risk_management',
                'name_en' => 'Risk Management',
                'name_ar' => 'إدارة المخاطر',
                'icon' => 'shield-alt',
                'route' => 'risk-management.dashboard',
                'permission' => 'risk_management.view',
            ],
            [
                'key' => 'health_safety',
                'name_en' => 'Health & Safety',
                'name_ar' => 'الصحة والسلامة',
                'icon' => 'first-aid',
                'route' => 'health-safety.dashboard',
                'permission' => 'health_safety.view',
            ],
            [
                'key' => 'system_settings',
                'name_en' => 'System Settings',
                'name_ar' => 'إعدادات النظام',
                'icon' => 'cogs',
                'route' => 'system-settings.dashboard',
                'permission' => 'system_settings.view',
            ],
            [
                'key' => 'user_management',
                'name_en' => 'User Management',
                'name_ar' => 'إدارة المستخدمين',
                'icon' => 'user-cog',
                'route' => 'user-management.dashboard',
                'permission' => 'user_management.view',
            ],
        ];

        $accessibleModules = collect($modules)->filter(function ($module) use ($user) {
            return $user->hasPermission($module['permission']) || $user->hasRole('super_admin');
        });

        return view('dashboard.index', compact('accessibleModules', 'user'));
    }
}
