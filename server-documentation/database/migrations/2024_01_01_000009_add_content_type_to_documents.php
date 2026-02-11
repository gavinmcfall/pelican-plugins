<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('documents')) {
            return;
        }

        // Only add if column doesn't already exist
        if (Schema::hasColumn('documents', 'content_type')) {
            return;
        }

        Schema::table('documents', function (Blueprint $table) {
            $table->string('content_type', 20)->default('html')->after('content');
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn('documents', 'content_type')) {
            Schema::table('documents', function (Blueprint $table) {
                $table->dropColumn('content_type');
            });
        }
    }
};
