<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules = [
            'real_estate' => ['Real Estate Investment', 'إدارة الاستثمار العقاري'],
            'technical_office' => ['Technical Office', 'المكتب الفني'],
            'contracts' => ['Contracts Management', 'إدارة العقود'],
            'financial' => ['Financial Management', 'الإدارة المالية'],
            'assets' => ['Assets & Equipment', 'الأصول والمعدات'],
            'purchases' => ['Purchases & Stores', 'المشتريات والمخازن'],
            'hr' => ['Human Resources', 'الموارد البشرية'],
            'maintenance' => ['Maintenance & Operation', 'الصيانة والتشغيل'],
            'partners' => ['Partner Management', 'إدارة الشركاء'],
            'documents' => ['Documents & Records', 'الوثائق والسجلات'],
            'secretarial' => ['Secretarial Management', 'الإدارة السكرتارية'],
            'public_admin' => ['Public Administration', 'الإدارة العامة'],
            'subcontractors' => ['Subcontractors', 'المقاولين من الباطن'],
            'contractor_items' => ['Item Master Library', 'مكتبة البنود الرئيسية'],
            'contractor_tenders' => ['Contracts & Tenders', 'العقود والمناقصات'],
            'payment_certificates' => ['Payment Certificates', 'شهادات الدفع'],
            'guarantees' => ['Guarantees Management', 'إدارة الضمانات'],
            'production_labor' => ['Production Labor', 'عمال الإنتاج'],
            'change_orders' => ['Change Orders & Claims', 'أوامر التغيير والمطالبات'],
            'contractor_monitoring' => ['Contractor Monitoring', 'مراقبة المقاولين'],
            'contractor_reports' => ['Reports Engine', 'محرك التقارير'],
            'reports' => ['Reports Department', 'قسم التقارير'],
            'risk_management' => ['Risk Management', 'إدارة المخاطر'],
            'health_safety' => ['Health & Safety', 'الصحة والسلامة'],
            'system_settings' => ['System Settings', 'إعدادات النظام'],
            'user_management' => ['User Management', 'إدارة المستخدمين'],
        ];

        $actions = [
            'view' => ['View', 'عرض'],
            'create' => ['Create', 'إنشاء'],
            'edit' => ['Edit', 'تعديل'],
            'delete' => ['Delete', 'حذف'],
            'approve' => ['Approve', 'موافقة'],
            'export' => ['Export', 'تصدير'],
            'import' => ['Import', 'استيراد'],
            'manage' => ['Manage', 'إدارة'],
        ];

        foreach ($modules as $moduleKey => $moduleNames) {
            foreach ($actions as $actionKey => $actionNames) {
                Permission::create([
                    'name' => "{$moduleKey}.{$actionKey}",
                    'display_name' => "{$actionNames[0]} {$moduleNames[0]}",
                    'display_name_ar' => "{$actionNames[1]} {$moduleNames[1]}",
                    'description' => "Permission to {$actionNames[0]} {$moduleNames[0]}",
                    'description_ar' => "صلاحية {$actionNames[1]} {$moduleNames[1]}",
                    'module' => $moduleKey,
                    'action' => $actionKey,
                ]);
            }
        }

        $specialPermissions = [
            [
                'name' => 'dashboard.access',
                'display_name' => 'Access Dashboard',
                'display_name_ar' => 'الوصول للوحة التحكم',
                'description' => 'Permission to access main dashboard',
                'description_ar' => 'صلاحية الوصول للوحة التحكم الرئيسية',
                'module' => 'dashboard',
                'action' => 'access',
            ],
            [
                'name' => 'system.admin',
                'display_name' => 'System Administration',
                'display_name_ar' => 'إدارة النظام',
                'description' => 'Full system administration access',
                'description_ar' => 'وصول كامل لإدارة النظام',
                'module' => 'system',
                'action' => 'admin',
            ],
        ];

        foreach ($specialPermissions as $permission) {
            Permission::create($permission);
        }
    }
}
