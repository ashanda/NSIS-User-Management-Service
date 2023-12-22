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
       Schema::connection('student_service')->create('student_details', function (Blueprint $table) {
            $table->id();
            $table->string('student_id')->unique();
            $table->unsignedBigInteger('organization_id');
            $table->unsignedBigInteger('year_grade_class_id');
            $table->string('admission_no');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('name_with_initials');
            $table->string('name_in_full');
            $table->string('address_line1');
            $table->string('address_line2')->nullable();
            $table->string('address_city');
            $table->string('telephone_residence')->nullable();
            $table->string('telephone_mobile')->nullable();
            $table->string('telephone_whatsapp')->nullable();
            $table->string('email_address')->nullable();
            $table->string('gender');
            $table->date('date_of_birth');
            $table->string('religion');
            $table->string('ethnicity');
            $table->string('birth_certificate_number');
            $table->string('profile_picture_path')->nullable();
            $table->text('health_conditions')->nullable();
            $table->date('admission_date');
            $table->decimal('admission_payment_amount', 10, 2);
            $table->integer('no_of_installments');
            $table->string('admission_status');
            $table->decimal('school_fee', 10, 2);
            $table->decimal('total_due', 10, 2);
            $table->string('payment_status');
            $table->string('academic_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_details');
    }
};
