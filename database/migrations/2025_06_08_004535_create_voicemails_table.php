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
        Schema::create('voicemails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Call information
            $table->string('call_sid', 64)->unique();
            $table->string('from_number', 32);
            $table->string('caller_country', 5)->nullable();
            $table->string('direction', 32)->default('inbound');
            $table->string('call_status', 32);
            
            // Recording information
            $table->string('recording_sid', 64)->nullable();
            $table->string('recording_url')->nullable();
            $table->integer('recording_duration')->nullable();
            $table->string('digits', 32)->nullable();
            
            // Transcription
            $table->text('transcription_text')->nullable();
            $table->boolean('transcription_processed')->default(false);
            
            // AI response
            $table->text('ai_response')->nullable();
            $table->boolean('sms_sent')->default(false);
            $table->timestamp('sms_sent_at')->nullable();
            
            $table->timestamps();
            
            $table->index(['user_id', 'created_at']);
            $table->index(['call_sid']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voicemails');
    }
};
