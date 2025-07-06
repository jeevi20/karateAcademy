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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            
            $table->string('student_reg_no')->unique();
           
            $table->date('enrollment_date');
            $table->enum('past_experience', ['yes', 'no'])->default('no');
            $table->enum('status', ['Active', 'Inactive', 'Graduated', 'Suspended'])->default('Active');
            
            $table->boolean('admission_granted')->default(false)->nullable();


            $table->timestamps();
            $table->softDeletes();
        
            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('karate_class_template_id')->nullable()->constrained('karate_class_templates')->onDelete('set null'); 
           
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
