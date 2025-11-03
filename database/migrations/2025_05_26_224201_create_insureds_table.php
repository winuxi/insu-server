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
        Schema::create('insurance_insureds', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->foreignId('insurance_id')->constrained('insurances')->onDelete('cascade')->onUpdate('cascade');
            $table->date('dob')->nullable();
            $table->decimal('age', 5, 2)->nullable();
            $table->tinyInteger('gender')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('height')->nullable();
            $table->string('weight')->nullable();
            $table->string('relation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insurance_insureds');
    }
};
