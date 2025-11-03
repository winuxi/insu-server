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
        Schema::table('insurance_payments', function (Blueprint $table) {
            $table->tinyInteger('status')->after('amount')->nullable();
            $table->foreignId('installment_id')->after('status')->nullable()->constrained('insurance_installments')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('insurance_payments', function (Blueprint $table) {
            $table->dropForeign(['installment_id']);
            $table->dropColumn(['status', 'installment_id']);
        });
    }
};
