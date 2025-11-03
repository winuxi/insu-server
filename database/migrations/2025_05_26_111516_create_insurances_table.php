
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
        Schema::create('insurances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('agent_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('policy_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('policy_pricing_id')->constrained('policy_pricings')->onUpdate('cascade')->onDelete('cascade');
            $table->string('agent_commission')->nullable();
            $table->date('start_date')->nullable();
            $table->integer('status');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insurances');
    }
};
