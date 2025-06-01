<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\IndustryType;
use App\Enums\QuoteStatus;
use App\Enums\QuoteSource;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('message');
            $table->string('location')->nullable();
            $table->enum('industry_type', IndustryType::values());
            $table->text('ai_response')->nullable();
            $table->text('edited_response')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->string('from_number', 32);
            $table->string('to_number', 32);
            $table->string('sms_id', 64)->nullable();
            $table->enum('status', QuoteStatus::values())->default('pending');
            $table->enum('source', QuoteSource::values())->default('sms');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
}; 