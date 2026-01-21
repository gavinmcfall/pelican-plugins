<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
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
