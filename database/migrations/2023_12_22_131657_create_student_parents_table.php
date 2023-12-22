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
            $table->string('relationship');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('nic');
            $table->string('higher_education_qualification');
            $table->string('occupation');
            $table->text('official_address');
            $table->text('permanent_address');
            $table->string('contact_official');
            $table->string('contact_mobile');
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
