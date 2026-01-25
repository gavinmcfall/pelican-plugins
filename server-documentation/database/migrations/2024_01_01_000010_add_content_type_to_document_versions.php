<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('document_versions', 'content_type')) {
            Schema::table('document_versions', function (Blueprint $table) {
                $table->string('content_type', 20)->default('html')->after('content');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('document_versions', 'content_type')) {
            Schema::table('document_versions', function (Blueprint $table) {
                $table->dropColumn('content_type');
            });
        }
    }
};
