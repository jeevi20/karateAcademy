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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade'); // Student making the payment
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade'); // User (branch staff) who records the payment
            $table->foreignId('event_id')->nullable()->constrained('events')->onDelete('cascade');

            $table->string('reference_no')->unique();
            $table->enum('payment_category', ['Registration', 'Grading Exam', 'Monthly Class', 'Certification', 'Other']);
            $table->integer('amount');
            $table->date('date_paid');
            $table->text('notes')->nullable();

            $table->foreignId('belt_want_to_receive')->nullable()->constrained('belts')->onDelete('set null');

            $table->string('admission_card_path')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
