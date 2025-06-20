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
        Schema::create('events', function (Blueprint $table) {
            $table->id();

            $table->foreignId('created_by');
        
            $table->string('title');
            $table->enum('event_type', ['tournament', 'seminar', 'grading exams', 'other']);
            $table->date('event_date');
            $table->time('start_time');
            $table->time('end_time')->nullable();
            $table->string('location')->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['upcoming', 'ongoing', 'completed', 'cancelled'])->default('upcoming');

            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
        
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
