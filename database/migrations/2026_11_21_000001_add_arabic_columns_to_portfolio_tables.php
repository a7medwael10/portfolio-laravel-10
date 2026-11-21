<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->string('name_ar')->nullable()->after('name');
            $table->string('title_ar')->nullable()->after('title');
            $table->text('bio_ar')->nullable()->after('bio');
            $table->text('about_text_ar')->nullable()->after('about_text');
            $table->string('location_ar')->nullable()->after('location');
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->string('title_ar')->nullable()->after('title');
            $table->text('description_ar')->nullable()->after('description');
        });

        Schema::table('experiences', function (Blueprint $table) {
            $table->string('title_ar')->nullable()->after('title');
            $table->string('company_ar')->nullable()->after('company');
            $table->string('work_location_ar')->nullable()->after('work_location');
            $table->json('description_ar')->nullable()->after('description');
        });

        Schema::table('education', function (Blueprint $table) {
            $table->string('degree_ar')->nullable()->after('degree');
            $table->string('institution_ar')->nullable()->after('institution');
            $table->string('location_ar')->nullable()->after('location');
            $table->string('field_of_study_ar')->nullable()->after('field_of_study');
            $table->string('grade_ar')->nullable()->after('grade');
            $table->json('description_ar')->nullable()->after('description');
        });

        Schema::table('skill_categories', function (Blueprint $table) {
            $table->string('name_ar')->nullable()->after('name');
        });

        Schema::table('skills', function (Blueprint $table) {
            $table->string('name_ar')->nullable()->after('name');
        });
    }

    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn(['name_ar', 'title_ar', 'bio_ar', 'about_text_ar', 'location_ar']);
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['title_ar', 'description_ar']);
        });

        Schema::table('experiences', function (Blueprint $table) {
            $table->dropColumn(['title_ar', 'company_ar', 'work_location_ar', 'description_ar']);
        });

        Schema::table('education', function (Blueprint $table) {
            $table->dropColumn(['degree_ar', 'institution_ar', 'location_ar', 'field_of_study_ar', 'grade_ar', 'description_ar']);
        });

        Schema::table('skill_categories', function (Blueprint $table) {
            $table->dropColumn(['name_ar']);
        });

        Schema::table('skills', function (Blueprint $table) {
            $table->dropColumn(['name_ar']);
        });
    }
};
