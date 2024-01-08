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
        Schema::connection('student_service')->create('student_payments', function (Blueprint $table) {
            $table->id();
            $table->string('student_id');
            $table->float('due_amount');
            $table->float('balance_payment');
            $table->string('balance_pay_type')->comment('remaining or extra');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_payments');
    }
};
