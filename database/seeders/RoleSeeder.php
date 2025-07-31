<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'super_admin',
                'display_name' => 'Super Administrator',
                'display_name_ar' => 'مدير النظام الرئيسي',
                'description' => 'Full system access with all permissions',
                'description_ar' => 'وصول كامل للنظام مع جميع الصلاحيات',
            ],
            [
                'name' => 'admin',
                'display_name' => 'Administrator',
                'display_name_ar' => 'مدير النظام',
                'description' => 'System administrator with most permissions',
                'description_ar' => 'مدير النظام مع معظم الصلاحيات',
            ],
            [
                'name' => 'finance_manager',
                'display_name' => 'Finance Manager',
                'display_name_ar' => 'مدير المالية',
                'description' => 'Manages financial operations and reports',
                'description_ar' => 'يدير العمليات المالية والتقارير',
            ],
            [
                'name' => 'hr_manager',
                'display_name' => 'HR Manager',
                'display_name_ar' => 'مدير الموارد البشرية',
                'description' => 'Manages human resources and payroll',
                'description_ar' => 'يدير الموارد البشرية والرواتب',
            ],
            [
                'name' => 'project_manager',
                'display_name' => 'Project Manager',
                'display_name_ar' => 'مدير المشاريع',
                'description' => 'Manages projects and technical operations',
                'description_ar' => 'يدير المشاريع والعمليات التقنية',
            ],
            [
                'name' => 'procurement_manager',
                'display_name' => 'Procurement Manager',
                'display_name_ar' => 'مدير المشتريات',
                'description' => 'Manages purchases and supplier relations',
                'description_ar' => 'يدير المشتريات وعلاقات الموردين',
            ],
            [
                'name' => 'maintenance_manager',
                'display_name' => 'Maintenance Manager',
                'display_name_ar' => 'مدير الصيانة',
                'description' => 'Manages maintenance operations and work orders',
                'description_ar' => 'يدير عمليات الصيانة وأوامر العمل',
            ],
            [
                'name' => 'employee',
                'display_name' => 'Employee',
                'display_name_ar' => 'موظف',
                'description' => 'Regular employee with limited access',
                'description_ar' => 'موظف عادي مع وصول محدود',
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
