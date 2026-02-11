#!/usr/bin/env php
<?php

/**
 * Server Documentation Plugin - Pre-Upgrade Migration Patch
 *
 * Run this script BEFORE upgrading from v1.0.x to v1.1.x to prevent data loss.
 *
 * This script modifies the installed plugin's migration files to prevent
 * them from dropping tables during the uninstall process.
 *
 * Usage:
 *   cd /var/www/pelican
 *   php plugins/server-documentation/scripts/pre-upgrade-patch.php
 *
 * Or via artisan tinker:
 *   php artisan tinker
 *   > include 'plugins/server-documentation/scripts/pre-upgrade-patch.php';
 */

// Detect Pelican installation
$pelicanRoot = null;
$possibleRoots = [
    dirname(__DIR__, 3),  // If run from plugins/server-documentation/scripts/
    getcwd(),              // Current working directory
    '/var/www/pelican',    // Common installation path
];

foreach ($possibleRoots as $root) {
    if (file_exists($root.'/artisan') && file_exists($root.'/plugins')) {
        $pelicanRoot = $root;
        break;
    }
}

if (! $pelicanRoot) {
    echo "ERROR: Could not detect Pelican installation.\n";
    echo "Please run this script from your Pelican root directory.\n";
    exit(1);
}

$pluginPath = $pelicanRoot.'/plugins/server-documentation';
$migrationsPath = $pluginPath.'/database/migrations';

if (! is_dir($migrationsPath)) {
    echo "ERROR: Server Documentation plugin not found at expected location.\n";
    echo "Expected: {$migrationsPath}\n";
    exit(1);
}

echo "=== Server Documentation Pre-Upgrade Patch ===\n\n";
echo "Pelican root: {$pelicanRoot}\n";
echo "Plugin path: {$pluginPath}\n\n";

// Define the migrations and their original down() content to replace
$migrations = [
    '2024_01_01_000001_create_documents_table.php' => [
        'search' => "Schema::dropIfExists('documents');",
        'has_complex_down' => false,
    ],
    '2024_01_01_000002_create_document_versions_table.php' => [
        'search' => "Schema::dropIfExists('document_versions');",
        'has_complex_down' => false,
    ],
    '2024_01_01_000003_create_document_server_table.php' => [
        'search' => "Schema::dropIfExists('document_server');",
        'has_complex_down' => false,
    ],
    '2024_01_01_000004_update_documents_type_column.php' => [
        'has_complex_down' => true,
    ],
    '2024_01_01_000005_add_unique_constraint_to_documents_slug.php' => [
        'has_complex_down' => true,
    ],
    '2024_01_01_000006_add_performance_indexes_and_fix_slug_constraint.php' => [
        'has_complex_down' => true,
    ],
    '2024_01_01_000007_convert_document_visibility_to_roles.php' => [
        'has_complex_down' => true,
    ],
    '2024_01_01_000008_add_server_id_index_to_document_server.php' => [
        'has_complex_down' => true,
    ],
    '2024_01_01_000009_add_content_type_to_documents.php' => [
        'has_complex_down' => true,
    ],
];

$patched = 0;
$skipped = 0;
$errors = 0;

foreach ($migrations as $filename => $config) {
    $filepath = $migrationsPath.'/'.$filename;

    if (! file_exists($filepath)) {
        echo "SKIP: {$filename} (not found - may be a newer version)\n";
        $skipped++;

        continue;
    }

    $content = file_get_contents($filepath);

    // Check if already patched (has empty down method comment)
    if (strpos($content, '// Intentionally empty - preserve data') !== false) {
        echo "SKIP: {$filename} (already patched)\n";
        $skipped++;

        continue;
    }

    // Replace the down() method with an empty one
    // Match the entire down() method including its body
    $pattern = '/public function down\(\): void\s*\{[^}]*(?:\{[^}]*\}[^}]*)*\}/s';
    $replacement = "public function down(): void\n    {\n        // Intentionally empty - preserve data on uninstall\n        // Patched by pre-upgrade-patch.php\n    }";

    $newContent = preg_replace($pattern, $replacement, $content, 1, $count);

    if ($count === 0) {
        echo "ERROR: {$filename} (could not find down() method to patch)\n";
        $errors++;

        continue;
    }

    // Create backup
    $backupPath = $filepath.'.bak';
    if (! file_exists($backupPath)) {
        copy($filepath, $backupPath);
    }

    // Write patched file
    if (file_put_contents($filepath, $newContent) === false) {
        echo "ERROR: {$filename} (could not write file)\n";
        $errors++;

        continue;
    }

    echo "PATCHED: {$filename}\n";
    $patched++;
}

echo "\n=== Summary ===\n";
echo "Patched: {$patched}\n";
echo "Skipped: {$skipped}\n";
echo "Errors: {$errors}\n";

if ($errors > 0) {
    echo "\nWARNING: Some migrations could not be patched.\n";
    echo "Please backup your documents using the Export feature before upgrading.\n";
    exit(1);
}

if ($patched > 0) {
    echo "\nSUCCESS: Your migrations have been patched.\n";
    echo "You can now safely uninstall the plugin to upgrade.\n";
    echo "Your documents will be preserved in the database.\n";
} else {
    echo "\nAll migrations were already patched or not found.\n";
}

echo "\nIMPORTANT: Always use the Export Backup feature before upgrading!\n";
