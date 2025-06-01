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
        Schema::create('user_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Business information
            $table->string('industry_type')->nullable(); // electrical, plumbing, tiling, carpentry, painting, general
            $table->string('phone')->nullable();

            // Pricing configuration
            $table->decimal('callout_fee', 10, 2)->nullable();
            $table->decimal('hourly_rate', 10, 2)->nullable();

            // AI response preferences
            $table->enum('response_tone', ['casual', 'polite', 'professional'])->default('casual');
            $table->text('preferred_cta')->nullable(); // Custom call-to-action message

            // Automation settings
            $table->boolean('auto_send_sms')->default(false);
            $table->boolean('auto_send_email')->default(false);

            // SMS integration
            $table->string('twilio_number')->nullable();

            // Usage tracking
            $table->integer('quotes_used')->default(0);
            $table->integer('quotes_limit')->default(100);

            $table->timestamps();
            $table->unique('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_settings');
    }
};