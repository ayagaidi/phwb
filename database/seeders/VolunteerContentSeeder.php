<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VolunteerContent;

class VolunteerContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VolunteerContent::truncate();

        VolunteerContent::create([
            'hero_title' => 'انضم كمتبرع',
            'hero_title_en' => 'Join as Volunteer',

            'hero_desc' => 'كن جزءاً من فريقنا و ساهم في تحسين الخدمات الصحية وتقديم الدعم للمجتمعات المحتاجة. المتبرع معنا فرصة للعطاء والنمو المهني والشخصي.',
            'hero_desc_en' => 'Become part of our team and contribute to improving health services and supporting communities in need. Volunteering with us is an opportunity for giving back and personal & professional growth.',

            'opportunities' => "• المشاركة في الحملات الصحية والتوعوية الميدانية\n• تنظيم ورش عمل ودورات تدريبية للصيادلة والمتبرعين\n• دعم الفرق الطبية في المناطق النائية والريفية\n• المساهمة في برامج التوزيع الدوائي والإغاثة الصحية\n• التدريب والتطوير المهني المستمر للمتبرعين",

            'opportunities_en' => "• Participate in field health and awareness campaigns\n• Organize workshops and training courses for pharmacists and volunteers\n• Support medical teams in remote and rural areas\n• Contribute to medicine distribution and health relief programs\n• Continuous professional training and development for volunteers",

            'is_published' => true,
        ]);
    }
}
