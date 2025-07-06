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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->text('body');
            $table->date('announcement_date')->nullable();
            $table->string('image')->nullable(); 
            $table->boolean('is_active')->default(true);
            $table->string('link')->nullable();
            $table->enum('audience', ['all', 'branchstaff', 'instructors', 'students'])->default('all'); 

            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();

           //Index for faster querying on 'audience' and 'is_active'
            $table->index(['audience', 'is_active']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
