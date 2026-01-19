<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('document_server', function (Blueprint $table) {
            // Add index on server_id for visibility queries that filter by server
            // The existing unique constraint on (document_id, server_id) doesn't optimize
            // queries that filter only by server_id
            $table->index('server_id', 'idx_document_server_server_id');
        });
    }

    public function down(): void
    {
        Schema::table('document_server', function (Blueprint $table) {
            $table->dropIndex('idx_document_server_server_id');
        });
    }
};
