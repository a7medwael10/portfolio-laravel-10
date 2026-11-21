<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $hasType = Schema::hasColumn('projects', 'type');
        $hasExperienceId = Schema::hasColumn('projects', 'experience_id');

        if (! $hasType || ! $hasExperienceId) {
            Schema::table('projects', function (Blueprint $table) use ($hasType, $hasExperienceId) {
                if (! $hasType) {
                    $table->string('type')->nullable()->default('freelance')->after('description');
                }
                if (! $hasExperienceId) {
                    $table->foreignId('experience_id')->nullable()->after('type')->constrained('experiences')->nullOnDelete();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            if (Schema::hasColumn('projects', 'experience_id')) {
                $table->dropForeign(['experience_id']);
                $table->dropColumn('experience_id');
            }
            if (Schema::hasColumn('projects', 'type')) {
                $table->dropColumn('type');
            }
        });
    }
};
