<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->string('content_type', 20)->default('html')->after('content');
        });
    }

    public function down(): void
    {
        // Intentionally empty - preserve data on uninstall
    }
};
