<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Skip if documents table doesn't exist
        if (! Schema::hasTable('documents')) {
            return;
        }

        // Skip if type column doesn't exist (may have been dropped by migration 007)
        if (! Schema::hasColumn('documents', 'type')) {
            return;
        }

        $driver = Schema::getConnection()->getDriverName();

        // Check if type column is already varchar (idempotent check)
        $columnType = $this->getColumnType('documents', 'type');
        $alreadyVarchar = str_contains(strtolower($columnType ?? ''), 'varchar');

        // Change enum to string for flexibility with new document types
        if (! $alreadyVarchar) {
            if ($driver === 'sqlite') {
                // SQLite doesn't support ALTER COLUMN, but it also doesn't enforce enum types
                // The column will accept any value, so we just need to update the data
            } elseif ($driver === 'mysql' || $driver === 'mariadb') {
                DB::statement('ALTER TABLE documents MODIFY COLUMN type VARCHAR(50) NOT NULL DEFAULT \'player\'');
            } elseif ($driver === 'pgsql') {
                // PostgreSQL: drop the enum constraint and change to varchar
                DB::statement('ALTER TABLE documents ALTER COLUMN type TYPE VARCHAR(50)');
                DB::statement('ALTER TABLE documents ALTER COLUMN type SET DEFAULT \'player\'');
            }
        }

        // Migrate old 'admin' type to 'server_admin' for all drivers (idempotent - only if 'admin' values exist)
        DB::table('documents')->where('type', 'admin')->update(['type' => 'server_admin']);
    }

    /**
     * Get the column type for a given table and column.
     */
    protected function getColumnType(string $table, string $column): ?string
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'mysql' || $driver === 'mariadb') {
            $result = DB::selectOne('SELECT COLUMN_TYPE FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ? AND COLUMN_NAME = ?', [$table, $column]);

            return $result?->COLUMN_TYPE;
        } elseif ($driver === 'pgsql') {
            $result = DB::selectOne('SELECT data_type FROM information_schema.columns WHERE table_name = ? AND column_name = ?', [$table, $column]);

            return $result?->data_type;
        } elseif ($driver === 'sqlite') {
            $columns = DB::select("PRAGMA table_info({$table})");
            foreach ($columns as $col) {
                if ($col->name === $column) {
                    return $col->type;
                }
            }
        }

        return null;
    }

    public function down(): void
    {
        // Only run if type column exists (migration 007 may have dropped it)
        if (! Schema::hasColumn('documents', 'type')) {
            return;
        }

        $driver = Schema::getConnection()->getDriverName();

        // Migrate back to old types
        DB::table('documents')->where('type', 'server_admin')->update(['type' => 'admin']);
        DB::table('documents')->whereIn('type', ['host_admin', 'server_mod'])->update(['type' => 'admin']);

        // Change back to enum (MySQL only - other drivers will just have varchar)
        if ($driver === 'mysql' || $driver === 'mariadb') {
            DB::statement('ALTER TABLE documents MODIFY COLUMN type ENUM(\'admin\', \'player\') NOT NULL DEFAULT \'player\'');
        }
    }
};
