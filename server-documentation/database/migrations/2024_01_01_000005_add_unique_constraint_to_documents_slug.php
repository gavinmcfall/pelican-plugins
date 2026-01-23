<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('documents')) {
            return;
        }

        // Check if unique constraint already exists
        $indexes = Schema::getIndexes('documents');
        $indexNames = array_column($indexes, 'name');

        // Skip if already has unique constraint or the partial index from migration 006
        if (in_array('documents_slug_unique', $indexNames) || in_array('idx_documents_slug_active', $indexNames)) {
            return;
        }

        Schema::table('documents', function (Blueprint $table) {
            $table->unique('slug');
        });
    }

    public function down(): void
    {
        // Only drop if the unique constraint exists
        // Migration 006 drops this and replaces with idx_documents_slug_active
        $indexes = Schema::getIndexes('documents');
        $indexNames = array_column($indexes, 'name');

        if (in_array('documents_slug_unique', $indexNames)) {
            Schema::table('documents', function (Blueprint $table) {
                $table->dropUnique(['slug']);
            });
        }
    }
};
