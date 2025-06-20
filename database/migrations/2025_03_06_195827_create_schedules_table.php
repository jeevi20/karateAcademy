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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            
            $table->date('schedule_date');
            $table->enum('status', ['scheduled', 'completed', 'canceled'])->default('scheduled');
        
            $table->foreignId('branch_id')->constrained()->onDelete('cascade');
            $table->foreignId('karate_class_template_id')->constrained('karate_class_templates')->onDelete('cascade');
            $table->unsignedBigInteger('instructor_id')->nullable();
            $table->foreign('instructor_id')->references('id')->on('users')->onDelete('set null');

        
            $table->timestamps();
            $table->softDeletes();
        });
        
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
