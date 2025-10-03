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
        Schema::create('unit_fee_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')->constrained('units')->cascadeOnDelete();
            $table->foreignId('lease_id')->nullable()->constrained('leases')->nullOnDelete();
            $table->foreignId('logged_by')->constrained('users')->cascadeOnDelete();
            $table->string('category');
            $table->text('description')->nullable();
            $table->decimal('amount', 10, 2);
            $table->date('incurred_at')->nullable();
            $table->string('attachment_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit_fee_logs');
    }
};
