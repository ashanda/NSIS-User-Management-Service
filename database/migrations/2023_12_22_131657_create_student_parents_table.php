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
        Schema::connection('student_service')->create('student_parents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organization_id');
            $table->string('student_id');
            $table->string('father_first_name');
            $table->string('father_last_name');
            $table->string('father_nic');
            $table->string('father_higher_education_qualification');
            $table->string('father_occupation');
            $table->text('father_official_address');
            $table->text('father_permanent_address');
            $table->string('father_contact_official');
            $table->string('father_contact_mobile');
            $table->string('mother_first_name');
            $table->string('mother_last_name');
            $table->string('mother_nic');
            $table->string('mother_higher_education_qualification');
            $table->string('mother_occupation');
            $table->text('mother_official_address');
            $table->text('mother_permanent_address');
            $table->string('mother_contact_official');
            $table->string('mother_contact_mobile');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_parents');
    }
};
