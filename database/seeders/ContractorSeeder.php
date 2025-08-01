<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ContractorItem;
use App\Models\ContractorTender;
use App\Models\PaymentCertificate;
use App\Models\Guarantee;
use App\Models\ProductionLabor;
use App\Models\ChangeOrder;
use App\Models\ContractorMonitoring;
use App\Models\ContractorReport;
use App\Models\User;

class ContractorSeeder extends Seeder
{
    public function run(): void
    {
        $superAdmin = User::where('email', 'superadmin@erp.com')->first();
        $admin = User::where('email', 'admin@erp.com')->first();

        $items = [
            [
                'code' => 'ITEM001',
                'name' => 'Concrete Grade 30',
                'name_ar' => 'خرسانة درجة 30',
                'description' => 'High-grade concrete for structural work',
                'description_ar' => 'خرسانة عالية الجودة للأعمال الإنشائية',
                'category' => 'Construction Materials',
                'category_ar' => 'مواد البناء',
                'unit' => 'Cubic Meter',
                'unit_ar' => 'متر مكعب',
                'unit_price' => 120.50,
                'currency' => 'USD',
                'specifications' => 'Compressive strength: 30 MPa',
                'specifications_ar' => 'قوة الضغط: 30 ميجا باسكال',
                'supplier' => 'ABC Construction Materials',
                'brand' => 'Premium Mix',
                'created_by' => $superAdmin->id,
            ],
            [
                'code' => 'ITEM002',
                'name' => 'Steel Reinforcement Bar 16mm',
                'name_ar' => 'حديد تسليح 16 مم',
                'description' => 'High tensile steel reinforcement bars',
                'description_ar' => 'حديد تسليح عالي المقاومة',
                'category' => 'Steel & Metal',
                'category_ar' => 'الحديد والمعادن',
                'unit' => 'Ton',
                'unit_ar' => 'طن',
                'unit_price' => 850.00,
                'currency' => 'USD',
                'specifications' => 'Grade 60, ASTM A615',
                'specifications_ar' => 'درجة 60، مواصفات ASTM A615',
                'supplier' => 'Steel Works Ltd',
                'brand' => 'SteelMax',
                'created_by' => $admin->id,
            ],
        ];

        foreach ($items as $item) {
            ContractorItem::create($item);
        }

        $tenders = [
            [
                'tender_number' => 'TND-2025-001',
                'title' => 'Construction of Office Building',
                'title_ar' => 'إنشاء مبنى إداري',
                'description' => 'Complete construction of 5-story office building',
                'description_ar' => 'إنشاء مبنى إداري مكون من 5 طوابق',
                'type' => 'public',
                'estimated_value' => 2500000.00,
                'currency' => 'USD',
                'publication_date' => now()->subDays(30),
                'submission_deadline' => now()->addDays(15),
                'opening_date' => now()->addDays(20),
                'status' => 'published',
                'requirements' => 'Minimum 10 years experience in commercial construction',
                'requirements_ar' => 'خبرة لا تقل عن 10 سنوات في البناء التجاري',
                'evaluation_criteria' => 'Technical capability (40%), Financial capacity (30%), Experience (30%)',
                'evaluation_criteria_ar' => 'القدرة الفنية (40%)، القدرة المالية (30%)، الخبرة (30%)',
                'created_by' => $superAdmin->id,
            ],
            [
                'tender_number' => 'TND-2025-002',
                'title' => 'Road Infrastructure Project',
                'title_ar' => 'مشروع البنية التحتية للطرق',
                'description' => 'Construction and maintenance of 10km highway',
                'description_ar' => 'إنشاء وصيانة طريق سريع بطول 10 كم',
                'type' => 'limited',
                'estimated_value' => 5000000.00,
                'currency' => 'USD',
                'publication_date' => now()->subDays(20),
                'submission_deadline' => now()->addDays(25),
                'opening_date' => now()->addDays(30),
                'status' => 'awarded',
                'awarded_to' => $admin->id,
                'awarded_amount' => 4800000.00,
                'award_date' => now()->subDays(5),
                'created_by' => $superAdmin->id,
            ],
        ];

        foreach ($tenders as $tender) {
            ContractorTender::create($tender);
        }

        $tender1 = ContractorTender::where('tender_number', 'TND-2025-002')->first();

        $certificates = [
            [
                'certificate_number' => 'PC-2025-001',
                'tender_id' => $tender1->id,
                'contractor_id' => $admin->id,
                'period_from' => now()->subDays(30),
                'period_to' => now(),
                'work_completed_value' => 500000.00,
                'previous_payments' => 0.00,
                'current_payment' => 500000.00,
                'retention_percentage' => 10.00,
                'retention_amount' => 50000.00,
                'net_payment' => 450000.00,
                'vat_percentage' => 15.00,
                'vat_amount' => 67500.00,
                'total_payment' => 517500.00,
                'status' => 'approved',
                'work_description' => 'Foundation and structural work completion',
                'work_description_ar' => 'إنجاز أعمال الأساسات والهيكل الإنشائي',
                'submission_date' => now()->subDays(10),
                'approval_date' => now()->subDays(5),
                'approved_by' => $superAdmin->id,
                'created_by' => $admin->id,
            ],
        ];

        foreach ($certificates as $certificate) {
            PaymentCertificate::create($certificate);
        }

        $guarantees = [
            [
                'guarantee_number' => 'GRT-2025-001',
                'tender_id' => $tender1->id,
                'contractor_id' => $admin->id,
                'type' => 'performance_bond',
                'type_ar' => 'ضمان حسن التنفيذ',
                'amount' => 480000.00,
                'currency' => 'USD',
                'percentage' => 10.00,
                'issuing_bank' => 'National Bank',
                'bank_reference' => 'NB-GRT-2025-001',
                'issue_date' => now()->subDays(60),
                'expiry_date' => now()->addMonths(18),
                'status' => 'active',
                'terms_conditions' => 'Standard performance bond terms',
                'terms_conditions_ar' => 'شروط ضمان حسن التنفيذ المعيارية',
                'created_by' => $superAdmin->id,
            ],
        ];

        foreach ($guarantees as $guarantee) {
            Guarantee::create($guarantee);
        }

        $laborRecords = [
            [
                'tender_id' => $tender1->id,
                'contractor_id' => $admin->id,
                'worker_name' => 'Ahmed Hassan',
                'worker_name_ar' => 'أحمد حسن',
                'worker_id' => 'WRK-001',
                'position' => 'Site Engineer',
                'position_ar' => 'مهندس موقع',
                'skill_level' => 'highly_skilled',
                'skill_level_ar' => 'مهارة عالية',
                'hourly_rate' => 25.00,
                'daily_rate' => 200.00,
                'monthly_rate' => 4000.00,
                'currency' => 'USD',
                'start_date' => now()->subDays(60),
                'status' => 'active',
                'total_hours_worked' => 480,
                'total_days_worked' => 60,
                'productivity_score' => 92.5,
                'certifications' => 'Professional Engineer License',
                'certifications_ar' => 'رخصة مهندس محترف',
                'safety_training' => 'OSHA 30-Hour Construction Safety',
                'safety_training_ar' => 'تدريب السلامة المهنية 30 ساعة',
                'last_safety_training' => now()->subDays(90),
                'created_by' => $admin->id,
            ],
        ];

        foreach ($laborRecords as $labor) {
            ProductionLabor::create($labor);
        }

        $changeOrders = [
            [
                'change_order_number' => 'CO-2025-001',
                'tender_id' => $tender1->id,
                'contractor_id' => $admin->id,
                'type' => 'variation_order',
                'type_ar' => 'أمر تغيير',
                'title' => 'Additional Drainage System',
                'title_ar' => 'نظام صرف إضافي',
                'description' => 'Installation of additional drainage system due to site conditions',
                'description_ar' => 'تركيب نظام صرف إضافي بسبب ظروف الموقع',
                'justification' => 'Required due to unexpected groundwater levels',
                'justification_ar' => 'مطلوب بسبب مستويات المياه الجوفية غير المتوقعة',
                'original_amount' => 4800000.00,
                'change_amount' => 150000.00,
                'new_total_amount' => 4950000.00,
                'currency' => 'USD',
                'time_extension_days' => 15,
                'original_completion_date' => now()->addMonths(12),
                'new_completion_date' => now()->addMonths(12)->addDays(15),
                'status' => 'approved',
                'priority' => 'medium',
                'submission_date' => now()->subDays(20),
                'approval_date' => now()->subDays(10),
                'approved_by' => $superAdmin->id,
                'created_by' => $admin->id,
            ],
        ];

        foreach ($changeOrders as $changeOrder) {
            ChangeOrder::create($changeOrder);
        }

        $monitoring = [
            [
                'tender_id' => $tender1->id,
                'contractor_id' => $admin->id,
                'evaluation_date' => now()->subDays(7),
                'evaluation_period' => 'Monthly Evaluation - January 2025',
                'evaluation_period_ar' => 'تقييم شهري - يناير 2025',
                'quality_score' => 88.5,
                'schedule_performance_score' => 92.0,
                'cost_performance_score' => 85.0,
                'safety_score' => 95.0,
                'communication_score' => 90.0,
                'overall_score' => 90.1,
                'performance_rating' => 'excellent',
                'performance_rating_ar' => 'ممتاز',
                'quality_comments' => 'High quality workmanship with attention to detail',
                'quality_comments_ar' => 'جودة عمل عالية مع الاهتمام بالتفاصيل',
                'schedule_comments' => 'Project is on schedule with good progress',
                'schedule_comments_ar' => 'المشروع يسير وفق الجدول الزمني بتقدم جيد',
                'improvement_recommendations' => 'Continue current practices',
                'improvement_recommendations_ar' => 'الاستمرار في الممارسات الحالية',
                'next_evaluation_date' => now()->addDays(23),
                'evaluated_by' => $superAdmin->id,
                'created_by' => $superAdmin->id,
            ],
        ];

        foreach ($monitoring as $monitor) {
            ContractorMonitoring::create($monitor);
        }

        $reports = [
            [
                'report_name' => 'Monthly Contractor Performance Report',
                'report_name_ar' => 'تقرير الأداء الشهري للمقاولين',
                'report_type' => 'performance_report',
                'report_type_ar' => 'تقرير الأداء',
                'description' => 'Comprehensive monthly performance analysis of all contractors',
                'description_ar' => 'تحليل شامل للأداء الشهري لجميع المقاولين',
                'format' => 'pdf',
                'date_from' => now()->subMonth()->startOfMonth(),
                'date_to' => now()->subMonth()->endOfMonth(),
                'status' => 'generated',
                'frequency' => 'monthly',
                'is_automated' => true,
                'generated_at' => now()->subDays(3),
                'file_path' => 'reports/monthly_performance_' . now()->format('Y_m') . '.pdf',
                'file_size' => 2048,
                'created_by' => $superAdmin->id,
            ],
        ];

        foreach ($reports as $report) {
            ContractorReport::create($report);
        }
    }
}
