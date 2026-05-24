<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Program::truncate();

        $programs = [
            [
                'title' => 'حملة التوعية بسلامة الأدوية',
                'title_en' => 'Medication Safety Awareness Campaign',
                'description' => 'برنامج توعوي يهدف إلى رفع مستوى الوعي بين المواطنين بأهمية الاستخدام الآمن للأدوية وتجنب الأخطاء الدوائية الشائعة.',
                'description_en' => 'An awareness program aimed at raising public awareness about the importance of safe medication use and avoiding common medication errors.',
                'image' => null,
                'video_url' => 'https://www.youtube.com/watch?v=example1',
                'is_published' => true,
            ],
            [
                'title' => 'برنامج الصيدلة المجتمعية',
                'title_en' => 'Community Pharmacy Program',
                'description' => 'مبادرة لتدريب الصيادلة على تقديم خدمات صيدلية متقدمة في المناطق النائية والريفية.',
                'description_en' => 'An initiative to train pharmacists to deliver advanced pharmaceutical services in remote and rural areas.',
                'image' => null,
                'video_url' => null,
                'is_published' => true,
            ],
            [
                'title' => 'حملة التطعيمات والتحصين',
                'title_en' => 'Vaccination and Immunization Campaign',
                'description' => 'برنامج مشترك مع وزارة الصحة لزيادة معدلات التطعيم في المجتمعات المحلية.',
                'description_en' => 'A joint program with the Ministry of Health to increase vaccination rates in local communities.',
                'image' => null,
                'video_url' => 'https://www.youtube.com/watch?v=example2',
                'is_published' => false,
            ],
            [
                'title' => 'تدريب الصيادلة الجدد',
                'title_en' => 'New Pharmacists Training Program',
                'description' => 'برنامج تدريبي مكثف لخريجي كليات الصيدلة على الممارسة المهنية الحديثة.',
                'description_en' => 'An intensive training program for pharmacy graduates on modern professional practice.',
                'image' => null,
                'video_url' => null,
                'is_published' => true,
            ],
        ];

        foreach ($programs as $program) {
            \App\Models\Program::create($program);
        }
    }
}
