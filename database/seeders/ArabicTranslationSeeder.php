<?php

namespace Database\Seeders;

use App\Models\Education;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;
use App\Models\SkillCategory;
use Illuminate\Database\Seeder;

class ArabicTranslationSeeder extends Seeder
{
    public function run(): void
    {
        if ($profile = Profile::first()) {
            $profile->update([
                'name_ar' => 'أحمد وائل',
                'title_ar' => 'مهندس برمجيات',
                'bio_ar' => 'بناء أنظمة خلفية قابلة للتوسع وتحسين واجهات برمجة التطبيقات RESTful APIs للتطبيقات الحديثة.',
                'about_text_ar' => "أنا أحمد وائل، مطور Full-Stack متخصص في استخدام Laravel لتطوير الواجهات الخلفية (Backend) وReact لبناء واجهات مستخدم حديثة وسريعة الاستجابة.\n\nلدي خبرة في تطوير تطبيقات ويب قابلة للتوسع، وواجهات برمجة التطبيقات RESTful APIs، ولوحات التحكم الإدارية، والربط مع الخدمات الخارجية. كما أقوم بتصميم وتحسين قواعد البيانات باستخدام MySQL وMongoDB مع تطبيق مبادئ OOP وSOLID ومعايير الكود النظيف.\n\nعملت على مشاريع متنوعة تشمل أنظمة إدارة المطاعم، ومنصات التجارة الإلكترونية، والتطبيقات التعليمية، والحلول اللوجستية، وأنظمة الحجوزات. أركز على تقديم حلول برمجية آمنة وقابلة للصيانة وسهلة الاستخدام لحل مشكلات الأعمال الواقعية.",
                'location_ar' => 'مصر',
            ]);
        }

        $educationTranslations = [
            'Information Technology Institute (ITI)' => [
                'degree_ar' => 'برنامج التدريب الاحترافي (9 أشهر)',
                'institution_ar' => 'معهد تكنولوجيا المعلومات (ITI)',
                'location_ar' => 'المنصورة، مصر',
                'field_of_study_ar' => 'مسار تطوير التطبيقات مفتوحة المصدر (Open-Source Applications Development)',
                'description_ar' => [
                    'تدريب مكثف في هندسة البرمجيات يشمل OOP وقواعد البيانات وأنظمة التشغيل وتطوير الويب وتقنيات الـ Backend مثل PHP وNode.js وMySQL وMongoDB وDocker وLinux وREST APIs.',
                    'مشروع التخرج: RestoMind – نظام ERP مدعوم بالذكاء الاصطناعي للمطاعم والمخابز مع التنبؤ بالطلب وإدارة المخزون ومساعد ذكي وسوق لتصريف الفائض.',
                ],
            ],
            'Faculty Of Engineering, Mansoura University' => [
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

        foreach ($educationTranslations as $institution => $data) {
            Education::where('institution', $institution)->update($data);
        }

        $experienceTranslations = [
            'Mutqana' => [
                'title_ar' => 'مطور واجهات خلفية (Backend Developer)',
                'company_ar' => 'متقنة (Mutqana)',
                'work_location_ar' => 'عن بُعد',
                'description_ar' => [
                    'تطوير واجهات برمجة تطبيقات RESTful APIs باستخدام Laravel وMySQL لتطبيقات الويب والموبايل، وإعادة هيكلة الكود القديم لتحسين الأداء وقابلية الصيانة، وتنفيذ ميزات ومنطق أعمال جديد مع ضمان استقرار النظام عبر تتبع الأخطاء والتعاون مع الفريق.',
                ],
            ],
            'Jadara' => [
                'title_ar' => 'مطور واجهات خلفية (Backend Developer)',
                'company_ar' => 'جدارة (Jadara)',
                'work_location_ar' => 'المنصورة، مصر',
                'description_ar' => [
                    'تطوير وصيانة الميزات الخلفية باستخدام Laravel وMySQL، وبناء وربط RESTful APIs لمنصات الويب والموبايل، والتعاون مع الفرق متعددة التخصصات لتقديم حلول برمجية موثوقة.',
                ],
            ],
            'Huma-volve' => [
                'title_ar' => 'متدرب تطوير واجهات خلفية (Backend Developer Intern)',
                'company_ar' => 'Huma-volve',
                'work_location_ar' => 'عن بُعد',
                'description_ar' => [
                    'خبرة عملية في Laravel وتطوير RESTful APIs وتصميم قواعد البيانات وGit، والمساهمة في تطوير الميزات الخلفية ضمن فريق عمل بمنهجية Agile ومراجعات الكود والتعاون مع الموجهين.',
                ],
            ],
            'Digital Egypt Pioneers Initiative - DEPI' => [
                'title_ar' => 'متدرب تطوير ويب PHP',
                'company_ar' => 'مبادرة رواد مصر الرقمية (DEPI)',
                'work_location_ar' => 'المنصورة، مصر',
                'description_ar' => [
                    'تدريب عملي في PHP وLaravel وMySQL مع التركيز على تطوير الواجهات الخلفية وتحسين قواعد البيانات وربط الـ APIs، إلى جانب تطوير مهارات التواصل التقني باللغة الإنجليزية للأعمال.',
                ],
            ],
            'Information Technology Institute (ITI)' => [
                'title_ar' => 'متدرب',
                'company_ar' => 'معهد تكنولوجيا المعلومات (ITI)',
                'work_location_ar' => 'المنصورة',
                'description_ar' => [],
            ],
            'Qader' => [
                'title_ar' => 'مطور واجهات خلفية (Backend Developer)',
                'company_ar' => 'قادر (Qader)',
                'work_location_ar' => '6 أكتوبر، مصر',
                'description_ar' => [
                    'تطوير واجهات Laravel REST APIs قابلة للتوسع لمنصة قادر للتوظيف وسوق الكفاءات، بما يشمل تصميم قواعد البيانات ومسارات العمل متعددة الأدوار وإدارة المواهب وعمليات التوظيف والربط مع الخدمات الخارجية والاختبارات الآلية.',
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
            'amanak' => [
                'title_ar' => 'أمانك — نظام إدارة النقدية والمحافظ متعدد المتاجر',
                'description_ar' => 'تطوير الواجهة الخلفية بـ Laravel وواجهات RESTful APIs لعمليات المتاجر المتعددة، وإدارة المحافظ والنقدية، والتحويلات والمعاملات والاشتراكات، وربط بوابات الدفع، ونظام الصلاحيات المبني على الأدوار (RBAC).',
            ],
            'spia' => [
                'title_ar' => 'منصة Spia',
                'description_ar' => 'تطوير الوحدات الأساسية في Laravel لمنصة SPIA، بما يشمل إدارة الإعلانات والفعاليات ومسارات الاشتراك، والاختبارات الإلكترونية المحددة بوقت مع التصحيح التلقائي وتوصيات المستوى، واشتراكات الباقات عبر التحويل البنكي. مع بناء لوحة التحكم وواجهات المستخدم بـ Blade والتحقق من المدخلات ودعم تعدد اللغات.',
            ],
            'maqaad' => [
                'title_ar' => 'مقعد (Maqaad)',
                'description_ar' => 'بناء تطبيق ويب بـ Laravel لمنصة مقعد يضم الموقع العام (المقاعد، طلبات تركيب المقاعد، المدونة، الأخبار، المعرض، الأسئلة الشائعة، التطوع، المساهمات، ونماذج التواصل)، مع دمج لوحة تحكم Filament مخصصة بصفحات وموارد وودجات لإدارة كامل محتوى الموقع والشركاء والسلايدر والإعدادات وطلبات المستخدمين.',
            ],
            'restomind' => [
                'title_ar' => 'RestoMind',
                'description_ar' => 'توليت دور مهندس الواجهة الخلفية لـ RestoMind API، وقمت بتطوير منظومة NestJS متعددة المستأجرين (Multi-tenant) على مستوى المؤسسات، تضم نظام أمان RBAC، وإدارة طلبات متعددة المطاعم، وتتبع المخزون وسلاسل الإمداد بنظام FIFO، وتخطيط الإنتاج اليومي، ومحرك توقعات ومساعد ذكي يعتمد على الذكاء الاصطناعي وRAG.',
            ],
            'qader-api' => [
                'title_ar' => 'Qader API',
                'description_ar' => 'هندسة وتطوير نظام خلفي معياري بـ Laravel باستخدام Domain-Driven Design وClean Architecture وRESTful APIs وDocker والاختبارات الآلية عبر مسارات العمل الأساسية للمنصة.',
            ],
        ];

        foreach ($projectTranslations as $slug => $data) {
            Project::where('slug', $slug)->update($data);
        }

        $categoryTranslations = [
            'Concepts' => 'المفاهيم البرمجية',
            'Backend Development' => 'تطوير الواجهات الخلفية (Backend)',
            'Frontend Development' => 'تطوير الواجهات الأمامية (Frontend)',
            'Databases' => 'قواعد البيانات',
            'Familiar With' => 'تقنيات أتعامل معها',
            'Tools & Environment' => 'الأدوات وبيئة العمل',
            'AI Development Tools' => 'أدوات التطوير بالذكاء الاصطناعي',
        ];

        foreach ($categoryTranslations as $name => $nameAr) {
            SkillCategory::where('name', $name)->update(['name_ar' => $nameAr]);
        }

        $skillTranslations = [
            'OOP,' => 'البرمجة كائنية التوجه (OOP)',
            'SOLID Principles' => 'مبادئ SOLID',
            'Design Patterns' => 'أنماط التصميم (Design Patterns)',
            'Data Structures & Algorithms' => 'هياكل البيانات والخوارزميات',
            'MVC Architecture' => 'معمارية MVC',
            'Database Design' => 'تصميم قواعد البيانات',
            'Query Optimization' => 'تحسين الاستعلامات',
        ];

        foreach ($skillTranslations as $name => $nameAr) {
            Skill::where('name', $name)->update(['name_ar' => $nameAr]);
        }
    }
}
