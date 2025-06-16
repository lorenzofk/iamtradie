<?php

declare(strict_types=1);

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
        Schema::table('voicemails', function (Blueprint $table): void {
            $table->text('summary_for_user')->nullable()->after('ai_response');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('voicemails', function (Blueprint $table): void {
            $table->dropColumn('summary_for_user');
        });
    }
};
