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
        Schema::table('insurances', function (Blueprint $table) {
            // Drop the existing foreign key constraint
            $table->dropForeign(['policy_pricing_id']);

            // Re-add the foreign key constraint without onDelete cascade
            $table->foreign('policy_pricing_id')
                ->references('id')
                ->on('policy_pricings')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('insurances', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['policy_pricing_id']);

            // Re-add the original constraint with onDelete cascade
            $table->foreign('policy_pricing_id')
                ->references('id')
                ->on('policy_pricings')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }
};
