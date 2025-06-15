<?php

declare(strict_types=1);

use App\Enums\IndustryType;
use App\Enums\ResponseTone;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('business_name')->nullable();
            $table->string('business_location')->nullable();

            // Phone numbers
            $table->string('phone_number')->nullable();
            $table->string('agent_sms_number')->nullable();

            // Industry type as enum
            $table->enum('industry_type', IndustryType::values())->nullable();

            // Pricing configuration
            $table->decimal('callout_fee', 10, 2)->nullable();
            $table->decimal('hourly_rate', 10, 2)->nullable();

            // AI response preferences
            $table->enum('response_tone', ResponseTone::values())->default(ResponseTone::CASUAL);

            // SMS and Call Automation settings
            $table->boolean('call_forward_enabled')->default(false);
            $table->integer('call_ring_duration')->default(10);
            $table->string('voicemail_message')->nullable();
            $table->boolean('auto_send_sms')->default(false);
            $table->boolean('auto_send_sms_after_voicemail')->default(false);

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
