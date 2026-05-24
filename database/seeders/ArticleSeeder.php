<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Article::truncate();

        $articles = [
            [
                'title' => 'أهمية الاستخدام الآمن للأدوية',
                'title_en' => 'The Importance of Safe Medication Use',
                'content' => 'يُعد الاستخدام الآمن للأدوية من أهم العوامل التي تساهم في الحفاظ على صحة الفرد والمجتمع. في هذا المقال نستعرض أبرز النصائح لتجنب الأخطاء الدوائية الشائعة.',
                'content_en' => 'Safe medication use is one of the most important factors in maintaining individual and community health. In this article, we review the most important tips to avoid common medication errors.',
                'image' => null,
                'images' => ['articles/sample1.jpg', 'articles/sample2.jpg'],
                'is_published' => true,
            ],
            [
                'title' => 'دور الصيدلي في المجتمع',
                'title_en' => 'The Role of the Pharmacist in Society',
                'content' => 'لا يقتصر دور الصيدلي على صرف الأدوية فقط، بل يمتد ليشمل تقديم الاستشارات الصحية والتوعية بأهمية الوقاية من الأمراض.',
                'content_en' => 'The pharmacist’s role is not limited to dispensing medications; it extends to providing health consultations and raising awareness about disease prevention.',
                'image' => null,
                'images' => null,
                'is_published' => true,
            ],
            [
                'title' => 'حملة التطعيمات الوطنية 2026',
                'title_en' => 'National Vaccination Campaign 2026',
                'content' => 'أطلقت جمعية صيادلة بلا حدود بالتعاون مع وزارة الصحة حملة واسعة للتطعيم ضد الأمراض المعدية في المناطق النائية.',
                'content_en' => 'The Pharmacists Without Borders Association, in cooperation with the Ministry of Health, launched a wide vaccination campaign against infectious diseases in remote areas.',
                'image' => null,
                'images' => ['articles/vaccine.jpg'],
                'is_published' => true,
            ],
            [
                'title' => 'كيف تحمي نفسك من الأخطاء الدوائية؟',
                'title_en' => 'How to Protect Yourself from Medication Errors?',
                'content' => 'تعرف على أهم الخطوات التي يجب اتباعها قبل تناول أي دواء لتجنب المضاعفات الخطيرة.',
                'content_en' => 'Learn the most important steps to follow before taking any medication to avoid serious complications.',
                'image' => null,
                'images' => null,
                'is_published' => false,
            ],
            [
                'title' => 'تدريب الصيادلة الشباب على الخدمات الصيدلانية المتقدمة',
                'title_en' => 'Training Young Pharmacists in Advanced Pharmaceutical Services',
                'content' => 'نظمت الجمعية ورشة عمل مكثفة لتأهيل 50 صيدلياً شاباً على تقديم خدمات صيدلانية متقدمة في المناطق الريفية.',
                'content_en' => 'The association organized an intensive workshop to qualify 50 young pharmacists to provide advanced pharmaceutical services in rural areas.',
                'image' => null,
                'images' => ['articles/training1.jpg', 'articles/training2.jpg'],
                'is_published' => true,
            ],
        ];

        foreach ($articles as $article) {
            \App\Models\Article::create($article);
        }
    }
}
