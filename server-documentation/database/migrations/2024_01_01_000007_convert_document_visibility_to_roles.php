<?php

use App\Models\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Create document_role pivot table
        // roles.id is bigint, documents.id is bigint
        Schema::create('document_role', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')->constrained()->cascadeOnDelete();
            $table->foreignId('role_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['document_id', 'role_id']);
        });

        // 2. Create document_user pivot table
        // users.id is int (not bigint), so we use unsignedInteger
        Schema::create('document_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['document_id', 'user_id']);
        });

        // 3. Create document_egg pivot table
        // eggs.id is int (not bigint), so we use unsignedInteger
        Schema::create('document_egg', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('egg_id');
            $table->foreign('egg_id')->references('id')->on('eggs')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['document_id', 'egg_id']);
        });

        // 4. Migrate existing host_admin documents to use Root Admin role
        $this->migrateHostAdminDocuments();

        // 5. Drop type column and its index
        Schema::table('documents', function (Blueprint $table) {
            // Check if the index exists before dropping (handle both naming conventions)
            $indexes = Schema::getIndexes('documents');
            $indexNames = array_column($indexes, 'name');

            // Migration 006 creates 'idx_documents_published_type'
            // Earlier versions might use 'documents_is_published_type_index'
            if (in_array('idx_documents_published_type', $indexNames)) {
                $table->dropIndex('idx_documents_published_type');
            } elseif (in_array('documents_is_published_type_index', $indexNames)) {
                $table->dropIndex('documents_is_published_type_index');
            }
        });

        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }

    public function down(): void
    {
        // 1. Re-add type column (only if it doesn't exist)
        if (!Schema::hasColumn('documents', 'type')) {
            Schema::table('documents', function (Blueprint $table) {
                $table->string('type')->default('player')->after('content');
            });

            // 2. Restore type values from role attachments
            $this->restoreTypeFromRoles();

            // 3. Re-add the index (using migration 006 naming convention)
            $indexes = Schema::getIndexes('documents');
            $indexNames = array_column($indexes, 'name');
            if (!in_array('idx_documents_published_type', $indexNames)) {
                Schema::table('documents', function (Blueprint $table) {
                    $table->index(['is_published', 'type'], 'idx_documents_published_type');
                });
            }
        }

        // 4. Drop the new pivot tables
        Schema::dropIfExists('document_egg');
        Schema::dropIfExists('document_user');
        Schema::dropIfExists('document_role');
    }

    /**
     * Migrate host_admin documents to use Root Admin role.
     * Other types (server_admin, server_mod, player) are left empty = visible to everyone.
     */
    protected function migrateHostAdminDocuments(): void
    {
        $rootAdminRole = DB::table('roles')
            ->where('name', Role::ROOT_ADMIN)
            ->first();

        if (!$rootAdminRole) {
            return;
        }

        $hostAdminDocIds = DB::table('documents')
            ->where('type', 'host_admin')
            ->pluck('id');

        foreach ($hostAdminDocIds as $docId) {
            DB::table('document_role')->insert([
                'document_id' => $docId,
                'role_id' => $rootAdminRole->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Restore type column values from role attachments when rolling back.
     */
    protected function restoreTypeFromRoles(): void
    {
        $rootAdminRole = DB::table('roles')
            ->where('name', Role::ROOT_ADMIN)
            ->first();

        if ($rootAdminRole) {
            $hostAdminDocIds = DB::table('document_role')
                ->where('role_id', $rootAdminRole->id)
                ->pluck('document_id');

            DB::table('documents')
                ->whereIn('id', $hostAdminDocIds)
                ->update(['type' => 'host_admin']);
        }

        // Documents without role attachments get 'player' (the default)
    }
};
