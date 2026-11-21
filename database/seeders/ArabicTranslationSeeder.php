<?php

namespace Database\Seeders;

use App\Models\Education;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\SkillCategory;
use Illuminate\Database\Seeder;

class ArabicTranslationSeeder extends Seeder
{
    public function run(): void
    {
        if ($profile = Profile::first()) {
            $profile->update([
                'name_ar' => 'أحمد وائل مجاهد',
                'title_ar' => 'مطور واجهات خلفية (Backend Developer)',
                'bio_ar' => 'بناء أنظمة خلفية قابلة للتوسع وتحسين واجهات برمجة التطبيقات RESTful APIs للتطبيقات الحديثة.',
                'about_text_ar' => 'مطور Backend بخبرة قوية في PHP (Laravel)، وبناء وتحسين RESTful APIs وأنظمة خلفية قابلة للتوسع. عملت على تطبيقات واقعية تشمل منصات متعددة البائعين، وأنظمة لوجستية، وواجهات برمجة لتطبيقات الموبايل، مع المساهمة في تطوير الميزات الأساسية وتحسين الأداء. ماهر في تصميم قواعد البيانات، وهندسة الأنظمة، وربط الـ APIs، مع تركيز قوي على كتابة كود نظيف وقابل للصيانة.',
                'location_ar' => 'المنصورة، مصر',
            ]);
        }

        $educationTranslations = [
            'Professional Training Program' => [
                'degree_ar' => 'برنامج التدريب الاحترافي',
                'institution_ar' => 'معهد تكنولوجيا المعلومات (ITI)',
                'location_ar' => 'المنصورة، مصر',
                'field_of_study_ar' => 'مسار تطوير التطبيقات مفتوحة المصدر (Open-Source Applications Development)',
                'description_ar' => [
                    'إتمام تدريب مكثف في أساسيات هندسة البرمجيات بما في ذلك OOP وقواعد البيانات وأنظمة التشغيل وتطوير الويب ضمن مسار تطوير التطبيقات مفتوحة المصدر.',
                    'اكتساب خبرة عملية في التقنيات الحديثة مثل PHP وPython وNode.js وMySQL وMongoDB وأطر عمل JavaScript وDocker وLinux وREST APIs لبناء تطبيقات قابلة للتوسع.',
                ],
            ],
            'B.Sc. Computer and Control Systems Engineering' => [
                'degree_ar' => 'بكالوريوس هندسة الحاسبات ونظم التحكم',
                'institution_ar' => 'كلية الهندسة، جامعة المنصورة',
                'location_ar' => 'المنصورة، مصر',
                'field_of_study_ar' => 'هندسة الحاسبات ونظم التحكم',
                'grade_ar' => 'امتياز (85.64%)',
                'description_ar' => [
                    'مشروع التخرج: Fadfadly API (منصة دعم نفسي مدعومة بالذكاء الاصطناعي)',
                ],
            ],
        ];

        foreach ($educationTranslations as $degree => $data) {
            Education::where('degree', $degree)->update($data);
        }

        $experienceTranslations = [
            'Mutqana' => [
                'title_ar' => 'مطور واجهات خلفية (Backend Developer)',
                'company_ar' => 'متقنة (Mutqana)',
                'work_location_ar' => 'عن بُعد',
                'description_ar' => [
                    'تطوير RESTful APIs باستخدام Laravel وMySQL لتطبيقات الويب والموبايل وبناء الأنظمة الخلفية من الصفر.',
                    'إعادة هيكلة وتحسين الكود القديم لرفع الأداء وتحسين القراءة وقابلية الصيانة.',
                    'تنفيذ ميزات ومنطق أعمال جديد مع تعزيز استقرار النظام عبر تتبع الأخطاء والتعاون مع الفريق.',
                ],
            ],
            'Jadara' => [
                'title_ar' => 'مطور واجهات خلفية (Backend Developer)',
                'company_ar' => 'جدارة (Jadara)',
                'work_location_ar' => 'المنصورة، مصر',
                'description_ar' => [
                    'تطوير وصيانة الميزات الخلفية لتطبيقات الشركة باستخدام Laravel وMySQL.',
                    'بناء وربط REST APIs لدعم منصات الويب وتطبيقات الموبايل.',
                    'التعاون مع فرق الواجهة الأمامية والموبايل لتقديم حلول برمجية موثوقة.',
                ],
            ],
            'Huma-volve' => [
                'title_ar' => 'متدرب تطوير واجهات خلفية (Backend Developer Intern)',
                'company_ar' => 'Huma-volve',
                'work_location_ar' => 'عن بُعد',
                'description_ar' => [
                    'اكتساب خبرة عملية في Laravel وتطوير RESTful APIs وتصميم قواعد البيانات وإدارة النسخ عبر Git.',
                    'المشاركة في مراجعات الكود والاجتماعات اليومية ومهام الفريق وفق منهجية Agile.',
                    'العمل بشكل وثيق مع الموجهين والمتدربين لتسليم ميزات خلفية مطابقة لمتطلبات المشروع.',
                ],
            ],
            'Digital Egypt Pioneers Initiative - DEPI' => [
                'title_ar' => 'متدرب تطوير ويب PHP',
                'company_ar' => 'مبادرة رواد مصر الرقمية (DEPI)',
                'work_location_ar' => 'المنصورة، مصر',
                'description_ar' => [
                    'اكتساب خبرة عملية في PHP وLaravel وMySQL أثناء تطوير تطبيقات الويب.',
                    'العمل على تطوير الواجهة الخلفية وتحسين قواعد البيانات وربط الـ APIs لرفع أداء النظام.',
                    'تطوير مهارات التواصل المهني عبر مسار Business English في Berlitz Egypt.',
                ],
            ],
        ];

        foreach ($experienceTranslations as $company => $data) {
            Experience::where('company', $company)->update($data);
        }

        $projectTranslations = [
            'hamelha' => [
                'title_ar' => 'حملها (Hamelha)',
                'description_ar' => 'تطوير لوحة التحكم باستخدام Filament، والمساهمة في وحدة المنتجات، وبناء محادثة فورية باستخدام Livewire، وتنفيذ واجهات العملاء والبائعين باستخدام Blade.',
            ],
            'show-gym' => [
                'title_ar' => 'Show Gym',
                'description_ar' => 'تطوير الـ APIs الأساسية للأعضاء وأصحاب الصالات الرياضية، بما يشمل الصفحة الرئيسية والتصنيفات وقائمة الصالات وتصفح العروض وعمليات CRUD الكاملة لعروض مقدمي الخدمة.',
            ],
            'tredo-api' => [
                'title_ar' => 'Tredo API',
                'description_ar' => 'إعادة هيكلة الكود القديم وتطوير الوحدات الأساسية للطلبات والمستودعات وCRM ونظام الدعم ولوحة التحكم، بالإضافة إلى ربط APIs شركات الشحن الخارجية لمعالجة وتتبع الشحنات.',
            ],
            'hotel-management-system' => [
                'title_ar' => 'نظام إدارة الفنادق',
                'description_ar' => 'تطوير واجهة العميل بما يشمل الصفحة الرئيسية وقوائم الغرف ومسار الحجز، وربط بوابة الدفع Stripe باستخدام Laravel وVue 3 وInertia.',
            ],
        ];

        foreach ($projectTranslations as $slug => $data) {
            Project::where('slug', $slug)->update($data);
        }

        $categoryTranslations = [
            'Programming Languages' => 'لغات البرمجة',
            'Backend Development' => 'تطوير الواجهات الخلفية (Backend)',
            'Frontend Development' => 'تطوير الواجهات الأمامية (Frontend)',
            'Databases' => 'قواعد البيانات',
            'Frameworks & Libraries' => 'أطر العمل والمكتبات',
            'Tools & Environment' => 'الأدوات وبيئة العمل',
        ];

        foreach ($categoryTranslations as $name => $nameAr) {
            SkillCategory::where('name', $name)->update(['name_ar' => $nameAr]);
        }
    }
}
