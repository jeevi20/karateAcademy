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
        Schema::create('salaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instructor_id')->nullable()->constrained('instructors')->onDelete('cascade');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade'); // User (admin) who records the payment
        
            $table->string('reference_no')->unique();
            $table->enum('salary_status', ['pending', 'paid'])->default('pending');
            $table->enum('paid_method', ['Cash', 'Bank Transfer', 'Cheque', 'Other'])->nullable();
            $table->decimal('paid_amount', 10, 2)->nullable();
            $table->date('paid_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salaries');
    }
};
