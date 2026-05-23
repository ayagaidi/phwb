<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\OrganizationalUnit;

class OrganizationalUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // مسح البيانات القديمة لتجنب التكرار عند إعادة التشغيل
        OrganizationalUnit::truncate();

        // 1. أولاً: الجمعية العمومية (أعلى سلطة في المنظمة)
        $generalAssembly = OrganizationalUnit::create([
            'name' => 'الجمعية العمومية',
            'name_en' => 'General Assembly',
            'title' => 'أعلى سلطة في المنظمة',
            'title_en' => 'Highest Authority in the Organisation',
            'parent_id' => null,
            'sort_order' => 1,
            'is_active' => true,
        ]);

        // 2. ثانياً: مجلس الإدارة (يتبع مباشرة للجمعية العمومية)
        $boardOfDirectors = OrganizationalUnit::create([
            'name' => 'مجلس الإدارة',
            'name_en' => 'Board of Directors',
            'title' => 'اعتماد السياسات والتوجهات العامة وإقرار الخطط الاستراتيجية',
            'title_en' => 'Approving policies, general directions, and strategic plans',
            'parent_id' => $generalAssembly->id,
            'sort_order' => 2,
            'is_active' => true,
        ]);

        // مكونات ومناصب مجلس الإدارة (الرئيس، نائب الرئيس، الأمين العام)
        $boardChairman = OrganizationalUnit::create([
            'name' => 'رئيس مجلس الإدارة',
            'name_en' => 'Chairman of the Board',
            'title' => 'الرئيس',
            'title_en' => 'Chairman',
            'parent_id' => $boardOfDirectors->id,
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $boardViceChairman = OrganizationalUnit::create([
            'name' => 'نائب رئيس مجلس الإدارة',
            'name_en' => 'Vice Chairman of the Board',
            'title' => 'نائب الرئيس',
            'title_en' => 'Vice Chairman',
            'parent_id' => $boardOfDirectors->id,
            'sort_order' => 2,
            'is_active' => true,
        ]);

        $boardSecretary = OrganizationalUnit::create([
            'name' => 'الأمين العام',
            'name_en' => 'Secretary General',
            'title' => 'الأمين العام',
            'title_en' => 'Secretary General',
            'parent_id' => $boardOfDirectors->id,
            'sort_order' => 3,
            'is_active' => true,
        ]);

        // 6. سادساً: اللجان المتخصصة (عند الحاجة) - تابعة لمجلس الإدارة
        $specializedCommittees = OrganizationalUnit::create([
            'name' => 'اللجان المتخصصة (عند الحاجة)',
            'name_en' => 'Specialized Committees (As needed)',
            'title' => 'اللجان الفنية والاستشارية',
            'title_en' => 'Technical & Advisory Committees',
            'parent_id' => $boardOfDirectors->id,
            'sort_order' => 4,
            'is_active' => true,
        ]);

        // تفريعات اللجان المتخصصة المنبثقة
        $committees = [
            ['name' => 'اللجنة العلمية', 'en' => 'Scientific Committee', 'order' => 1],
            ['name' => 'اللجنة القانونية', 'en' => 'Legal Committee', 'order' => 2],
            ['name' => 'لجنة الجودة والاعتماد', 'en' => 'Quality & Accreditation Committee', 'order' => 3],
            ['name' => 'اللجنة التحضيرية', 'en' => 'Preparatory Committee', 'order' => 4],
        ];

        foreach ($committees as $committee) {
            OrganizationalUnit::create([
                'name' => $committee['name'],
                'name_en' => $committee['en'],
                'title' => $committee['name'],
                'title_en' => $committee['en'],
                'parent_id' => $specializedCommittees->id,
                'sort_order' => $committee['order'],
                'is_active' => true,
            ]);
        }

        // 3. ثالثاً: الإدارة التنفيذية (المدير التنفيذي) - تابعة لمجلس الإدارة
        $executiveDirector = OrganizationalUnit::create([
            'name' => 'الإدارة التنفيذية',
            'name_en' => 'Executive Management',
            'title' => 'المدير التنفيذي',
            'title_en' => 'Executive Director',
            'parent_id' => $boardOfDirectors->id,
            'sort_order' => 3,
            'is_active' => true,
        ]);

        // 4. رابعاً: الإدارات التنفيذية والنوعية (تابعة مباشرة للمدير التنفيذي)
        
        // 4.1 إدارة اللوجستيات والدعم
        $logisticsDept = OrganizationalUnit::create([
            'name' => 'إدارة اللوجستيات والدعم',
            'name_en' => 'Logistics & Support Department',
            'title' => 'إدارة الإمداد، التوريد، النقل، التخزين والدعم الفني',
            'title_en' => 'Logistics, Supply Chain, Warehousing, & Tech Support',
            'parent_id' => $executiveDirector->id,
            'sort_order' => 1,
            'is_active' => true,
        ]);

        // 4.2 إدارة الموارد البشرية والتطوع
        $hrDept = OrganizationalUnit::create([
            'name' => 'إدارة الموارد البشرية والتطوع',
            'name_en' => 'Human Resources & Volunteering Department',
            'title' => 'استقطاب المتطوعين، إدارة شؤون الأعضاء، التدريب، وتقييم الأداء',
            'title_en' => 'Volunteer Recruitment, Member Affairs, Training, & Performance Evaluation',
            'parent_id' => $executiveDirector->id,
            'sort_order' => 2,
            'is_active' => true,
        ]);

        // 4.3 إدارة المشاريع والبرامج
        $projectsDept = OrganizationalUnit::create([
            'name' => 'إدارة المشاريع والبرامج',
            'name_en' => 'Projects & Programs Department',
            'title' => 'تخطيط وتنفيذ المشاريع ومتابعة البرامج المجتمعية والتقييم',
            'title_en' => 'Project Planning, Implementation, Program Monitoring & Evaluation',
            'parent_id' => $executiveDirector->id,
            'sort_order' => 3,
            'is_active' => true,
        ]);

        // 4.4 إدارة الإعلام والعلاقات العامة
        $mediaDept = OrganizationalUnit::create([
            'name' => 'إدارة الإعلام والعلاقات العامة',
            'name_en' => 'Media & Public Relations Department',
            'title' => 'الإعلام الرقمي والتقليدي، السوشيال ميديا والتغطية الإعلامية للفعاليات',
            'title_en' => 'Digital & Traditional Media, Social Media, & Events PR Coverage',
            'parent_id' => $executiveDirector->id,
            'sort_order' => 4,
            'is_active' => true,
        ]);

        // 4.5 الإدارة المالية
        $financeDept = OrganizationalUnit::create([
            'name' => 'الإدارة المالية',
            'name_en' => 'Financial Management Department',
            'title' => 'إعداد الميزانيات، إدارة المصروفات والإيرادات، والتقارير المالية',
            'title_en' => 'Budgeting, Expense & Revenue Management, & Financial Reporting',
            'parent_id' => $executiveDirector->id,
            'sort_order' => 5,
            'is_active' => true,
        ]);

        // 5. خامساً: الفروع والمكاتب (تابعة للإدارة التنفيذية / المدير التنفيذي)
        $branchesOffices = OrganizationalUnit::create([
            'name' => 'الفروع والمكاتب',
            'name_en' => 'Branches & Offices',
            'title' => 'تخطيط وتنفيذ المشاريع ومتابعة البرامج الصحية والمجتمعية بالفروع',
            'title_en' => 'Branch Project Planning, Health Programs, & Local Reporting',
            'parent_id' => $executiveDirector->id,
            'sort_order' => 6,
            'is_active' => true,
        ]);
    }
}