<?php

namespace Database\Seeders;

use App\Models\Education;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;
use App\Models\SkillCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CvDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Ahmed Wael Mujahid',
            'email' => 'ahmed.wael1025@gmail.com',
            'password' => Hash::make('101418_wR@2002'),
        ]);

        Profile::create([
            'name' => 'Ahmed Wael Mujahid',
            'title' => 'Backend Developer',
            'hero_image' => 'avatars/avatar.png',
            'bio' => 'Building scalable backends and optimizing RESTful APIs for modern applications.',
            'about_text' => 'Backend Developer with solid experience in PHP (Laravel), building and optimizing RESTful APIs and scalable backend systems. Worked on real-world applications including multi-vendor platforms, logistics systems, and mobile APIs, contributing to core features and performance improvements. Skilled in database design, system architecture, and API integration, with a strong focus on writing clean, maintainable code.',
            'email' => 'ahmed.wael1025@gmail.com',
            'phone' => '+201212808098',
            'github_url' => 'https://github.com/a7medwael10',
            'linkedin_url' => 'https://linkedin.com/in/a7med-wael',
            'location' => 'Mansoura, Egypt',
        ]);

        Education::create([
            'degree' => 'Professional Training Program',
            'institution' => 'Information Technology Institute (ITI)',
            'institution_url' => 'https://iti.gov.eg/diplomaStructure/139758dc-e1ee-4d2c-ba87-08dbe615d378/tracks/4d854c93-3ac7-411b-5cf6-08ddad7f3080/eb1cf1fe-b577-4d09-fe07-08dbe75ac461',
            'location' => 'Mansoura, Egypt',
            'field_of_study' => 'Open-Source Applications Development Track',
            'start_date' => '2025-10-01',
            'end_date' => null,
            'description' => [
                'Completed intensive training in software engineering fundamentals including OOP, databases, operating systems, and web development through the Open-Source Applications Development Track.',
                'Gained hands-on experience with modern technologies such as PHP, Python, Node.js, MySQL, MongoDB, JavaScript frameworks, Docker, Linux, and REST APIs for building scalable applications.',
            ],
        ]);

        Education::create([
            'degree' => 'B.Sc. Computer and Control Systems Engineering',
            'institution' => 'Faculty Of Engineering, Mansoura University',
            'institution_url' => 'https://engfac.mans.edu.eg/',
            'location' => 'Mansoura, Egypt',
            'field_of_study' => 'Computer and Control Systems Engineering',
            'start_date' => '2020-09-01',
            'end_date' => '2025-06-01',
            'grade' => 'Excellent (85.64%)',
            'description' => [
                'Graduation project : Fadfadly API (An AI-driven mental health support platform)',
            ],
        ]);

        Experience::create([
            'title' => 'Backend Developer',
            'company' => 'Mutqana',
            'work_location' => 'Remote',
            'company_url' => 'https://www.linkedin.com/company/mutqana/',
            'start_date' => '2025-10-01',
            'end_date' => null,
            'description' => [
                'Developed RESTful APIs using Laravel and MySQL for web and mobile applications, building backend systems from scratch.',
                'Refactored and optimized legacy code to improve performance, readability, and maintainability.',
                'Implemented new features and business logic, while enhancing system stability through debugging and collaboration.',
            ],
        ]);

        Experience::create([
            'title' => 'Backend Developer',
            'company' => 'Jadara',
            'work_location' => 'Mansoura, Egypt',
            'company_url' => 'https://jaadara.com/',
            'start_date' => '2025-07-01',
            'end_date' => '2025-10-01',
            'description' => [
                'Developing and maintaining backend features for company applications using Laravel and MySQL.',
                'Building and integrating REST APIs to support web and mobile platforms.',
                'Collaborating with front-end and mobile teams to deliver reliable business solutions.',
            ],
        ]);

        Experience::create([
            'title' => 'Back End Developer Intern',
            'company' => 'Huma-volve',
            'work_location' => 'Remote',
            'company_url' => 'https://huma-volve/',
            'start_date' => '2025-06-01',
            'end_date' => '2025-07-01',
            'description' => [
                'Gained hands-on experience in Laravel, RESTful API development, database design, and Git version control.',
                'Participated in code reviews, daily stand-ups, and collaborative team tasks following Agile methodology.',
                'Worked closely with mentors and fellow interns to deliver backend features aligned with project requirements.',
            ],
        ]);

        Experience::create([
            'title' => 'PHP Web Development Intern',
            'company' => 'Digital Egypt Pioneers Initiative - DEPI',
            'company_url' => 'https://depi.gov.eg/content/home',
            'work_location' => 'Mansoura, Egypt',
            'start_date' => '2024-04-01',
            'end_date' => '2024-10-01',
            'description' => [
                'Gained hands-on experience in PHP, Laravel, and MySQL while developing web applications.',
                'Worked on backend development, database optimization, and API integration to enhance the system\'s performance.',
                'Enhanced business communication skills through Berlitz Egypt (Business English Track).',
            ],
        ]);

        Project::create([
            'title' => 'Hamelha',
            'slug' => 'hamelha',
            'description' => 'Developed admin panel using Filament, contributed to product module, built real-time chat using Livewire, and implemented customer/vendor interfaces with Blade.',
        ]);

        Project::create([
            'title' => 'Show Gym',
            'slug' => 'show-gym',
            'description' => 'Developed core API features for both members and gym owners, including home, categories, gyms listing, offers browsing, and full CRUD operations for provider offers.',
        ]);

        Project::create([
            'title' => 'Tredo API',
            'slug' => 'tredo-api',
            'description' => 'Refactored legacy code and developed core modules for orders, warehouses, CRM, support system, admin panel, and integrated external shipping company APIs for shipment processing and tracking.',
        ]);

        Project::create([
            'title' => 'Hotel Management System',
            'slug' => 'hotel-management-system',
            'description' => 'Developed client-side features including homepage, room listings, and reservation flow, and integrated Stripe payment gateway using Laravel, Vue 3, and Inertia.',
        ]);

        $programmingLangCategory = SkillCategory::create(['name' => 'Programming Languages']);
        $backendCategory = SkillCategory::create(['name' => 'Backend Development']);
        $frontendCategory = SkillCategory::create(['name' => 'Frontend Development']);
        $dbCategory = SkillCategory::create(['name' => 'Databases']);
        $frameworksCategory = SkillCategory::create(['name' => 'Frameworks & Libraries']);
        $toolsCategory = SkillCategory::create(['name' => 'Tools & Environment']);

        foreach (['PHP', 'JavaScript', 'Python (Basics)', 'Java (Basics)'] as $name) {
            Skill::create(['category_id' => $programmingLangCategory->id, 'name' => $name]);
        }

        foreach (['PHP (Laravel)', 'RESTful APIs', 'MVC Architecture', 'Eloquent ORM'] as $name) {
            Skill::create(['category_id' => $backendCategory->id, 'name' => $name]);
        }

        foreach (['HTML', 'CSS', 'JavaScript', 'Blade', 'Bootstrap'] as $name) {
            Skill::create(['category_id' => $frontendCategory->id, 'name' => $name]);
        }

        foreach (['MySQL', 'MongoDB'] as $name) {
            Skill::create(['category_id' => $dbCategory->id, 'name' => $name]);
        }

        foreach (['Filament', 'Vue.js (Basics)', 'React (Basics)', 'Django (Basics)'] as $name) {
            Skill::create(['category_id' => $frameworksCategory->id, 'name' => $name]);
        }

        foreach (['Git', 'GitHub', 'Postman', 'Linux'] as $name) {
            Skill::create(['category_id' => $toolsCategory->id, 'name' => $name]);
        }
    }
}
