<?php

declare(strict_types=1);

namespace Starter\ServerDocumentation\Services;

use App\Models\Server;
use App\Models\User;

/**
 * Processes template variables in document content.
 *
 * Supports variables like:
 * - {{user.name}}, {{user.email}}, {{user.id}}, {{user.role}}
 * - {{server.name}}, {{server.uuid}}, {{server.address}}, {{server.egg}}
 * - {{date}}, {{time}}, {{datetime}}
 *
 * To show a literal variable (not replaced), escape with backslash:
 * - \{{user.name}} will display as {{user.name}}
 */
class VariableProcessor
{
    /**
     * Available variables and their descriptions for documentation.
     *
     * @return array<string, string>
     */
    public static function getAvailableVariables(): array
    {
        return [
            // User variables
            '{{user.name}}' => 'Current user\'s display name',
            '{{user.username}}' => 'Current user\'s username',
            '{{user.email}}' => 'Current user\'s email address',
            '{{user.id}}' => 'Current user\'s ID',
            '{{user.role}}' => 'Current user\'s primary role',

            // Server variables (only available in server context)
            '{{server.name}}' => 'Server name',
            '{{server.uuid}}' => 'Server UUID',
            '{{server.id}}' => 'Server ID',
            '{{server.egg}}' => 'Server egg/game type name',
            '{{server.node}}' => 'Node name where server is hosted',
            '{{server.address}}' => 'Server address (IP:port)',
            '{{server.memory}}' => 'Allocated memory (MB)',
            '{{server.disk}}' => 'Allocated disk space (MB)',
            '{{server.cpu}}' => 'CPU limit percentage',

            // Date/time variables
            '{{date}}' => 'Current date (Y-m-d)',
            '{{time}}' => 'Current time (H:i)',
            '{{datetime}}' => 'Current date and time',
            '{{year}}' => 'Current year',

            // Escaping
            '\\{{...}}' => 'Escape a variable to show it literally (e.g., \\{{user.name}} shows as {{user.name}})',
        ];
    }

    /**
     * Process all variables in content.
     */
    public function process(string $content, ?User $user = null, ?Server $server = null): string
    {
        // First, fix variables mangled by rich text editor auto-linking
        // e.g., {{<a href="http://user.name">user.name</a>}} -> {{user.name}}
        $content = $this->fixMangledVariables($content);

        // Temporarily replace escaped variables with placeholders
        // \{{var}} or \\{{var}} -> placeholder
        $escapedVars = [];
        $content = preg_replace_callback('/\\\\(\{\{[a-z_.]+\}\})/i', function ($matches) use (&$escapedVars) {
            $placeholder = '___ESCAPED_VAR_' . count($escapedVars) . '___';
            $escapedVars[$placeholder] = $matches[1]; // Store without backslash

            return $placeholder;
        }, $content) ?? $content;

        // Process user variables
        $content = $this->processUserVariables($content, $user);

        // Process server variables
        $content = $this->processServerVariables($content, $server);

        // Process date/time variables
        $content = $this->processDateVariables($content);

        // Restore escaped variables (they show as literal {{var}})
        foreach ($escapedVars as $placeholder => $original) {
            $content = str_replace($placeholder, $original, $content);
        }

        return $content;
    }

    /**
     * Fix variables that were mangled by rich text editor auto-linking.
     * The editor converts {{user.name}} to {{<a href="...">user.name</a>}}
     */
    protected function fixMangledVariables(string $content): string
    {
        // Pattern to match variables with embedded anchor tags
        // e.g., {{<a ...>user.name</a>}} or {{<a ...>server.name</a>}}
        return preg_replace(
            '/\{\{<a[^>]*>([a-z_.]+)<\/a>\}\}/i',
            '{{$1}}',
            $content
        ) ?? $content;
    }

    /**
     * Process user-related variables.
     */
    protected function processUserVariables(string $content, ?User $user): string
    {
        if ($user === null) {
            $user = auth()->user();
        }

        if ($user === null) {
            // Replace with empty or placeholder if no user
            $replacements = [
                '{{user.name}}' => '',
                '{{user.username}}' => '',
                '{{user.email}}' => '',
                '{{user.id}}' => '',
                '{{user.role}}' => '',
            ];
        } else {
            $replacements = [
                '{{user.name}}' => e($user->name ?? $user->username),
                '{{user.username}}' => e($user->username),
                '{{user.email}}' => e($user->email),
                '{{user.id}}' => (string) $user->id,
                '{{user.role}}' => e($user->roles->first()?->name ?? 'User'),
            ];
        }

        return str_replace(array_keys($replacements), array_values($replacements), $content);
    }

    /**
     * Process server-related variables.
     */
    protected function processServerVariables(string $content, ?Server $server): string
    {
        if ($server === null) {
            // Replace with empty or placeholder if no server context
            $replacements = [
                '{{server.name}}' => '',
                '{{server.uuid}}' => '',
                '{{server.id}}' => '',
                '{{server.egg}}' => '',
                '{{server.node}}' => '',
                '{{server.address}}' => '',
                '{{server.memory}}' => '',
                '{{server.disk}}' => '',
                '{{server.cpu}}' => '',
            ];
        } else {
            // Build server address from allocation
            $address = '';
            if ($server->allocation) {
                $alloc = $server->allocation;
                // Use alias if available, otherwise use address
                // Address may already include port, so check before appending
                $host = $alloc->alias ?: $alloc->address;
                if (!str_contains($host, ':')) {
                    $address = $host . ':' . $alloc->port;
                } else {
                    $address = $host;
                }
            }

            $replacements = [
                '{{server.name}}' => e($server->name),
                '{{server.uuid}}' => e($server->uuid),
                '{{server.id}}' => (string) $server->id,
                '{{server.egg}}' => e($server->egg?->name ?? ''),
                '{{server.node}}' => e($server->node?->name ?? ''),
                '{{server.address}}' => e($address),
                '{{server.memory}}' => (string) ($server->memory ?? ''),
                '{{server.disk}}' => (string) ($server->disk ?? ''),
                '{{server.cpu}}' => (string) ($server->cpu ?? ''),
            ];
        }

        return str_replace(array_keys($replacements), array_values($replacements), $content);
    }

    /**
     * Process date/time variables.
     */
    protected function processDateVariables(string $content): string
    {
        $now = now();

        $replacements = [
            '{{date}}' => $now->format('Y-m-d'),
            '{{time}}' => $now->format('H:i'),
            '{{datetime}}' => $now->format('Y-m-d H:i'),
            '{{year}}' => $now->format('Y'),
        ];

        return str_replace(array_keys($replacements), array_values($replacements), $content);
    }

    /**
     * Check if content contains any variables.
     */
    public function hasVariables(string $content): bool
    {
        return (bool) preg_match('/\{\{[a-z_.]+\}\}/i', $content);
    }

    /**
     * Extract all variables used in content.
     *
     * @return array<string>
     */
    public function extractVariables(string $content): array
    {
        preg_match_all('/\{\{([a-z_.]+)\}\}/i', $content, $matches);

        return array_unique($matches[0] ?? []);
    }
}
