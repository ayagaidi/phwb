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
        Schema::create('membership_applications', function (Blueprint $table) {
            $table->id();

            // البيانات الشخصية
            $table->string('full_name');
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->string('phone');
            $table->string('whatsapp')->nullable();
            $table->string('email');
            $table->string('city');
            $table->text('address')->nullable();

            // البيانات المهنية
            $table->string('qualification')->nullable();      // بكالوريوس صيدلة، ماجستير...
            $table->string('university')->nullable();
            $table->string('graduation_year')->nullable();
            $table->string('license_number')->nullable();
            $table->string('current_workplace')->nullable();
            $table->string('years_experience')->nullable();
            $table->string('specialization')->nullable();

            // طلب العضوية
            $table->enum('membership_type', ['full_member', 'student_member', 'supporter'])->default('full_member');
            $table->text('reason');                           // لماذا تريد الانضمام
            $table->text('contribution_areas')->nullable();   // مجالات المساهمة
            $table->boolean('available_for_fieldwork')->default(false);

            // إدارة
            $table->string('status')->default('pending');     // pending, approved, rejected
            $table->text('admin_notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membership_applications');
    }
};
