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
        Schema::create('trashes', function (Blueprint $table) {
            $table->id();

            $table->string('model_type');  // To store  model name
            $table->unsignedBigInteger('model_id'); // To store ID of the record
            $table->json('data');  // To store the record data in JSON format
            $table->foreignId('deleted_by')->nullable();//To store who delete it

            $table->timestamps();
            $table->softDeletes();  // To track when the record was deleted

            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trashes');
    }
};
