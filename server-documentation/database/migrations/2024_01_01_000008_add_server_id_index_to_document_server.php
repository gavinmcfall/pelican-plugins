<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Only add if doesn't exist
        $indexes = Schema::getIndexes('document_server');
        $indexNames = array_column($indexes, 'name');

        if (!in_array('idx_document_server_server_id', $indexNames)) {
            Schema::table('document_server', function (Blueprint $table) {
                $table->index('server_id', 'idx_document_server_server_id');
            });
        }
    }

    public function down(): void
    {
        // Intentionally empty - preserve data on uninstall
    }

    private function getForeignKeyOnColumn(string $table, string $column): ?string
    {
        $database = DB::getDatabaseName();
        $result = DB::selectOne("
            SELECT kcu.CONSTRAINT_NAME
            FROM information_schema.KEY_COLUMN_USAGE kcu
            JOIN information_schema.TABLE_CONSTRAINTS tc
              ON tc.CONSTRAINT_NAME = kcu.CONSTRAINT_NAME
              AND tc.TABLE_SCHEMA = kcu.TABLE_SCHEMA
              AND tc.TABLE_NAME = kcu.TABLE_NAME
            WHERE kcu.TABLE_SCHEMA = ?
              AND kcu.TABLE_NAME = ?
              AND kcu.COLUMN_NAME = ?
              AND tc.CONSTRAINT_TYPE = 'FOREIGN KEY'
        ", [$database, $table, $column]);

        return $result?->CONSTRAINT_NAME;
    }
};
