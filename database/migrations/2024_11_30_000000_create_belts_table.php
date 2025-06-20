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
        Schema::create('belts', function (Blueprint $table) {
            $table->id();
            $table->string('belt_name');
            $table->string('rank');
            $table->string('color');
            $table->text('requirements');
            $table->string('max_attempts');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('belts');
    }
};
