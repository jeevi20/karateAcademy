<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('belt_id')->nullable()->constrained('belts')->onDelete('cascade');

            $table->enum('achievement_type', ['past_belt', 'academy_belt', 'medal', 'certificate', 'awards']);
            $table->string('achievement_name');
            $table->date('achievement_date');
            $table->string('organization_name')->nullable();
            $table->string('remarks')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('achievements');
    }
};

