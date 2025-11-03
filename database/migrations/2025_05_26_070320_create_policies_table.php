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
        Schema::create('policies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('policy_type_id')->constrained()->onUpdate('cascade');
            $table->foreignId('policy_sub_type_id')->constrained()->onUpdate('cascade');
            $table->integer('coverage_type');
            $table->integer('total_insured_person');
            $table->integer('liability_risk');
            $table->string('sum_assured');
            $table->foreignId('policy_document_type_id')->nullable()->constrained('document_types')->onUpdate('cascade');
            $table->foreignId('claim_document_type_id')->nullable()->constrained('document_types')->onUpdate('cascade');
            $table->foreignId('tax_id')->constrained()->onUpdate('cascade');
            $table->text('description')->nullable();
            $table->text('term')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('policies');
    }
};
