<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('documents')) {
            return;
        }

        $indexes = Schema::getIndexes('documents');
        $indexNames = array_column($indexes, 'name');

        // Add performance indexes only if they don't exist
        Schema::table('documents', function (Blueprint $table) use ($indexNames) {
            // Note: idx_documents_published_type uses 'type' column which may be dropped by migration 007
            // Only add if type column exists and index doesn't
            if (!in_array('idx_documents_published_type', $indexNames) && Schema::hasColumn('documents', 'type')) {
                $table->index(['is_published', 'type'], 'idx_documents_published_type');
            }
            if (!in_array('idx_documents_global_published', $indexNames)) {
                $table->index(['is_global', 'is_published'], 'idx_documents_global_published');
            }
            if (!in_array('idx_documents_sort', $indexNames)) {
                $table->index('sort_order', 'idx_documents_sort');
            }
        });

        // Refresh index list after adding
        $indexes = Schema::getIndexes('documents');
        $indexNames = array_column($indexes, 'name');

        // Fix slug uniqueness to allow reuse after soft delete
        // Skip if already has the partial index
        if (in_array('idx_documents_slug_active', $indexNames)) {
            // Already migrated, just ensure document_versions unique exists
            $this->ensureDocumentVersionsUnique();
            return;
        }

        // This requires database-specific handling
        $driver = DB::getDriverName();

        // Only drop if the old unique constraint exists
        if (in_array('documents_slug_unique', $indexNames)) {
            Schema::table('documents', function (Blueprint $table) {
                // First, drop the existing unique constraint
                $table->dropUnique(['slug']);
            });
        }

        if ($driver === 'mysql' || $driver === 'mariadb') {
            // MySQL/MariaDB: Use a partial unique index workaround
            // Create a generated column that's null when deleted
            DB::statement('ALTER TABLE documents ADD COLUMN slug_unique VARCHAR(255) GENERATED ALWAYS AS (IF(deleted_at IS NULL, slug, NULL)) STORED');
            DB::statement('CREATE UNIQUE INDEX idx_documents_slug_active ON documents(slug_unique)');
        } elseif ($driver === 'pgsql') {
            // PostgreSQL: Use a partial unique index
            DB::statement('CREATE UNIQUE INDEX idx_documents_slug_active ON documents(slug) WHERE deleted_at IS NULL');
        } elseif ($driver === 'sqlite') {
            // SQLite 3.9+: Use a partial unique index
            DB::statement('CREATE UNIQUE INDEX idx_documents_slug_active ON documents(slug) WHERE deleted_at IS NULL');
        } else {
            // Fallback for unsupported drivers: regular unique (slug reuse after soft delete won't work)
            Schema::table('documents', function (Blueprint $table) {
                $table->unique('slug');
            });
        }

        // Add unique constraint on document versions to prevent race condition duplicates
        $this->ensureDocumentVersionsUnique();
    }

    /**
     * Ensure document_versions has the unique constraint.
     */
    protected function ensureDocumentVersionsUnique(): void
    {
        if (!Schema::hasTable('document_versions')) {
            return;
        }

        $versionIndexes = Schema::getIndexes('document_versions');
        $versionIndexNames = array_column($versionIndexes, 'name');

        if (!in_array('idx_document_versions_unique', $versionIndexNames)) {
            Schema::table('document_versions', function (Blueprint $table) {
                $table->unique(['document_id', 'version_number'], 'idx_document_versions_unique');
            });
        }
    }

    public function down(): void
    {
        $driver = DB::getDriverName();

        // Remove version unique constraint (if exists)
        $versionIndexes = Schema::getIndexes('document_versions');
        $versionIndexNames = array_column($versionIndexes, 'name');
        if (in_array('idx_document_versions_unique', $versionIndexNames)) {
            Schema::table('document_versions', function (Blueprint $table) {
                $table->dropUnique('idx_document_versions_unique');
            });
        }

        // Remove slug constraint based on driver (if exists)
        $indexes = Schema::getIndexes('documents');
        $indexNames = array_column($indexes, 'name');

        if (in_array('idx_documents_slug_active', $indexNames)) {
            if ($driver === 'mysql' || $driver === 'mariadb') {
                DB::statement('DROP INDEX idx_documents_slug_active ON documents');
                if (Schema::hasColumn('documents', 'slug_unique')) {
                    DB::statement('ALTER TABLE documents DROP COLUMN slug_unique');
                }
            } elseif ($driver === 'pgsql' || $driver === 'sqlite') {
                DB::statement('DROP INDEX idx_documents_slug_active');
            }
        }

        // Restore original unique constraint (if not exists)
        if (!in_array('documents_slug_unique', $indexNames)) {
            Schema::table('documents', function (Blueprint $table) {
                $table->unique('slug');
            });
        }

        // Remove performance indexes (only if they exist)
        // Note: idx_documents_published_type may have been dropped by migration 007
        Schema::table('documents', function (Blueprint $table) use ($indexNames) {
            if (in_array('idx_documents_published_type', $indexNames)) {
                $table->dropIndex('idx_documents_published_type');
            }
            if (in_array('idx_documents_global_published', $indexNames)) {
                $table->dropIndex('idx_documents_global_published');
            }
            if (in_array('idx_documents_sort', $indexNames)) {
                $table->dropIndex('idx_documents_sort');
            }
        });
    }
};
